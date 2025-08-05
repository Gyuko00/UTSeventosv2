<?php

/**
 * Modelo para actualizar usuarios
 */
class UserUpdateCRUDModel extends Model
{
    protected ValidatePersonData $validatePersonData;
    protected ValidateUserData $validateUserData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validatePersonData = new ValidatePersonData();
        $this->validateUserData = new ValidateUserData();
    }

    public function updateUser(int $id, array $personData, array $userData)
    {
        try {
            $this->validateId($id);
            $this->validatePersonData->validate($personData);
            $this->validateUserData->validate($userData, true);

            $this->getDB()->beginTransaction();

            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, ['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            $personId = $row['id_persona'];

            $sqlPerson = 'UPDATE personas SET 
                            tipo_documento = :tipo_documento, 
                            numero_documento = :numero_documento, 
                            nombres = :nombres,
                            apellidos = :apellidos, 
                            telefono = :telefono, 
                            correo_personal = :correo_personal, 
                            departamento = :departamento,
                            municipio = :municipio, 
                            direccion = :direccion
                          WHERE id_persona = :id_persona';

            $personParams = $personData;
            $personParams['id_persona'] = $personId;
            $this->query($sqlPerson, $personParams);

            $userParams = [
                'id' => $id,
                'usuario' => $userData['usuario'],
                'id_rol' => $userData['id_rol']
            ];

            $sqlUser = 'UPDATE usuarios SET usuario = :usuario, id_rol = :id_rol';

            if (!empty(trim($userData['contrasenia'] ?? ''))) {
                $sqlUser .= ', contrasenia = :contrasenia';
                $userParams['contrasenia'] = password_hash($userData['contrasenia'], PASSWORD_DEFAULT);
            }

            $sqlUser .= ' WHERE id_usuario = :id';

            $this->query($sqlUser, $userParams);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario actualizado correctamente'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
