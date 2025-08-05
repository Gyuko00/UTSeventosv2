<?php

/**
 * Modelo para gestionar CRUD de usuarios desde el administrador
 */
class AdminUserCRUDModel extends Model
{
    protected UserCreateCRUDModel $userCreateCRUDModel;
    protected UserUpdateCRUDModel $userUpdateCRUDModel;
    protected UserActivateCRUDModel $userActivateCRUDModel;
    protected UserDeleteCRUDModel $userDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userCreateCRUDModel = new UserCreateCRUDModel($db);
        $this->userUpdateCRUDModel = new UserUpdateCRUDModel($db);
        $this->userActivateCRUDModel = new UserActivateCRUDModel($db);
        $this->userDeleteCRUDModel = new UserDeleteCRUDModel($db);
    }

    public function createUser(array $personData, array $userData)
    {
        return $this->userCreateCRUDModel->createUser($personData, $userData);
    }

    public function updateUser(int $id, array $personData, array $userData)
    {
        return $this->userUpdateCRUDModel->updateUser($id, $personData, $userData);
    }

    public function activateUser(int $id): array
    {
        return $this->userActivateCRUDModel->activateUser($id);
    }

    public function deleteUser(int $id): array
    {
        return $this->userDeleteCRUDModel->deleteUser($id);
    }
}
