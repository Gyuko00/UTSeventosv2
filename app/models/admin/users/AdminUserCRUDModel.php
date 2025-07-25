<?php

/**
 * Modelo para gestionar CRUD de usuarios invitados desde el administrador
 */
class AdminUserCRUDModel extends Model
{
    protected LoginUserModel $loginUserModel;
    protected ValidatePersonData $validatePersonData;
    protected ValidateUserData $validateUserData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->loginUserModel = new LoginUserModel($db);
        $this->validatePersonData = new ValidatePersonData();
        $this->validateUserData = new ValidateUserData();
    }

    private function hashPasswordIfPresent(array &$userData)
    {
        if (!empty($userData['contrasenia'])) {
            $userData['contrasenia'] = password_hash($userData['contrasenia'], PASSWORD_DEFAULT);
        } else {
            unset($userData['contrasenia']);
        }
    }

    public function userExist($usuario)
    {
        return $this->loginUserModel->userExist($usuario);
    }

    public function documentExist($numero_documento)
    {
        return $this->loginUserModel->documentExist($numero_documento);
    }

    public function createUser(array $personData, array $userData)
    {
        error_log('userData: ' . print_r($userData, true));
        error_log('personData: ' . print_r($personData, true));

        try {
            $this->validatePersonData->validate($personData);
            $this->validateUserData->validate($userData);

            if ($this->userExist($userData['usuario'])) {
                return ['status' => 'error', 'message' => 'Usuario ya existe'];
            }
            if ($this->documentExist($personData['numero_documento'])) {
                return ['status' => 'error', 'message' => 'Documento ya existe'];
            }

            $this->getDB()->beginTransaction();

            $sqlPerson = 'INSERT INTO personas (tipo_documento, numero_documento, nombres, apellidos, telefono, correo_personal, 
                          departamento, municipio, direccion)
                          VALUES (:tipo_documento, :numero_documento, :nombres, :apellidos, :telefono, :correo_personal, 
                          :departamento, :municipio, :direccion)';
            $this->query($sqlPerson, $personData);
            $personId = $this->getDB()->lastInsertId();

            $sqlUser = 'INSERT INTO usuarios (usuario, contrasenia, activo, id_rol, id_persona)
                        VALUES (:usuario, :contrasenia, 1, :id_rol, :id_persona)';
            $this->hashPasswordIfPresent($userData);
            $userData['id_persona'] = $personId;

            $this->query($sqlUser, $userData);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario creado exitosamente'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateUser(int $id, array $personData, array $userData)
    {
        try {
            $this->validateId($id);
            $this->validatePersonData->validate($personData);
            $this->validateUserData->validate($userData);

            $this->getDB()->beginTransaction();

            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            $personId = $row['id_persona'];

            $sqlPerson = 'UPDATE personas SET tipo_documento = :tipo_documento, numero_documento = :numero_documento, nombres = :nombres, 
                          apellidos = :apellidos, telefono = :telefono, correo_personal = :correo_personal, departamento = :departamento, 
                          municipio = :municipio, direccion = :direccion
                          WHERE id_persona = :id_persona';
            $personData['id_persona'] = $personId;
            $this->query($sqlPerson, $personData);

            $sqlUser = 'UPDATE usuarios SET usuario = :usuario, contrasenia = :contrasenia, activo = 1, 
                        id_rol = :id_rol';
            $params = [':usuario' => $userData['usuario'], ':contrasenia' => $userData['contrasenia'],
                ':id_rol' => $userData['id_rol']];
            $this->hashPasswordIfPresent($userData);
            $sqlUser .= ' WHERE id_usuario = :id';
            $params[':id'] = $id;

            $this->query($sqlUser, $params);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario actualizado correctamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteUser(int $id)
    {
        try {
            $this->validateId($id);
            $this->getDB()->beginTransaction();

            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            $this->query('UPDATE usuarios SET activo = 0 WHERE id_usuario = :id', [':id' => $id]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario desactivado correctamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
