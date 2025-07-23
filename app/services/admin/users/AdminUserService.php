<?php

/**
 * AdminUserService: capa de servicio para usuarios desde el administrador
 */
class AdminUserService {

    private AdminUserGettersModel $gettersModel;
    private AdminGuestCRUDModel $guestModel;
    private AdminSpeakerCRUDModel $speakerModel;

    private AdminCreateUserService $createUserService;
    private AdminUpdateUserService $updateUserService;
    private AdminDeleteUserService $deleteUserService;


    public function __construct(PDO $db) {
        $this->gettersModel = new AdminUserGettersModel($db);
        $this->guestModel  = new AdminGuestCRUDModel($db);
        $this->speakerModel = new AdminSpeakerCRUDModel($db);

        $this->createUserService = new AdminCreateUserService($db);
        $this->updateUserService = new AdminUpdateUserService($db);
        $this->deleteUserService = new AdminDeleteUserService($db);
    }
    
    public function createUserWithRole(int $idUsuarioAdmin, array $personData, array $userData, array $roleSpecificData = []): array {
        return $this->createUserService->createUserWithRole($idUsuarioAdmin, $personData, $userData, $roleSpecificData);
    }

    public function updateUserWithRole(int $idUsuarioAdmin, int $id, array $personData, array $userData, array $roleSpecificData = []): array {
        return $this->updateUserService->updateUserWithRole($idUsuarioAdmin, $id, $personData, $userData, $roleSpecificData);
    }

    public function deleteUser(int $idUsuarioAdmin, int $id): array {
        return $this->deleteUserService->deleteUser($idUsuarioAdmin, $id);
    }

    public function getAllUsers(): array {
        return $this->gettersModel->getAllUsers();
    }
    
    public function getUserById(int $id): array {
        return $this->gettersModel->getUserById($id);
    }
    
    public function getAllGuests(): array {
        return $this->guestModel->getAllGuests();
    }
    
    public function getGuestById(int $id): array {
        return $this->guestModel->getGuestById($id);
    }
    
    public function getAllSpeakers(): array {
        return $this->speakerModel->getAllSpeakers();
    }
    
    public function getSpeakerById(int $id): array {
        return $this->speakerModel->getSpeakerById($id);
    }
    
}
