<?php

/**
 * Modelo para crear usuarios
 */
class UserCreateCRUDModel extends Model
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
}
