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
            $this->validateUserData->validate($userData, true);
    
            $this->getDB()->beginTransaction();
    
            // Obtener ID de persona
            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, ['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
    
            $personId = $row['id_persona'];
    
            // Actualizar persona
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
    
            // Preparar parámetros de usuario
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
    

    public function deleteUser(int $id): array
    {
        try {
            $this->validateId($id);
            $this->getDB()->beginTransaction();
    
            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
    
            $id_persona = (int) $row['id_persona'];
    
            $this->query('UPDATE usuarios SET activo = 0 WHERE id_usuario = :id', [':id' => $id]);
    
            $this->query('UPDATE personas SET activo = 0 WHERE id_persona = :id_persona', [':id_persona' => $id_persona]);
    
            $this->getDB()->commit();
    
            return ['status' => 'success', 'message' => 'Usuario y persona desactivados correctamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    

    public function activateUser(int $id): array
    {
        try {
            $this->validateId($id);
            $this->getDB()->beginTransaction();
    
            $sqlGetPerson = 'SELECT id_persona, id_rol FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
    
            $personId = (int)$row['id_persona'];
            $rol = (int)$row['id_rol'];
    
            $this->query('UPDATE usuarios SET activo = 1 WHERE id_usuario = :id', [':id' => $id]);
            $this->query('UPDATE personas SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);
    
            if ($rol === 3) {
                $this->query('UPDATE invitados SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);
            } elseif ($rol === 2) {
                $this->query('UPDATE ponentes SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);
            }
    
            $this->getDB()->commit();
    
            return ['status' => 'success', 'message' => 'Usuario y registros relacionados activados correctamente'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            error_log("Error en activateUser Model: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    
}
