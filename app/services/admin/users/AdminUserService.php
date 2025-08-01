<?php

/**
 * AdminUserService: capa de servicio para usuarios desde el administrador
 */
class AdminUserService
{
    private AdminUserGettersModel $gettersModel;
    private AdminGuestCRUDModel $guestModel;
    private AdminSpeakerCRUDModel $speakerModel;
    private AdminCreateUserService $createUserService;
    private AdminUpdateUserService $updateUserService;
    private AdminDeleteUserService $deleteUserService;

    private AdminGuestGettersModel $guestGettersModel;
    private AdminSpeakerGettersModel $speakerGettersModel;

    private AdminUserCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;

    public function __construct(PDO $db)
    {
        $this->gettersModel = new AdminUserGettersModel($db);
        $this->guestModel = new AdminGuestCRUDModel($db);
        $this->speakerModel = new AdminSpeakerCRUDModel($db);
        $this->guestGettersModel = new AdminGuestGettersModel($db);
        $this->speakerGettersModel = new AdminSpeakerGettersModel($db);
        $this->createUserService = new AdminCreateUserService($db);
        $this->updateUserService = new AdminUpdateUserService($db);
        $this->deleteUserService = new AdminDeleteUserService($db);

        $this->crudModel = new AdminUserCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
    }

    public function createUserWithRole(int $idUsuarioAdmin, array $personData, array $userData, array $roleSpecificData = []): array
    {
        return $this->createUserService->createUserWithRole($idUsuarioAdmin, $personData, $userData, $roleSpecificData);
    }

    public function updateUserWithRole(int $idUsuarioAdmin, int $id, array $personData, array $userData, array $roleSpecificData = []): array
    {
        return $this->updateUserService->updateUserWithRole($idUsuarioAdmin, $id, $personData, $userData, $roleSpecificData);
    }

    public function deleteUser(int $idUsuarioAdmin, int $id): array
    {
        return $this->deleteUserService->deleteUser($idUsuarioAdmin, $id);
    }

    public function getAllUsers(): array
    {
        return $this->gettersModel->getAllUsers();
    }

    public function getUserById(int $id): array
    {
        return $this->gettersModel->getUserById($id);
    }

    public function getAllGuests(): array
    {
        return $this->guestModel->getAllGuests();
    }

    public function getGuestById(int $id): array
    {
        return $this->guestModel->getGuestById($id);
    }

    public function getAllSpeakers(): array
    {
        return $this->speakerModel->getAllSpeakers();
    }

    public function getSpeakerById(int $id): array
    {
        return $this->speakerModel->getSpeakerById($id);
    }

    public function getGuestByPersonId(int $idPersona): array
    {
        return $this->guestGettersModel->getGuestByPersonId($idPersona);
    }

    public function getSpeakerByPersonId(int $idPersona): array
    {
        return $this->speakerGettersModel->getSpeakerByPersonId($idPersona);
    }

    public function activateUser(int $idUsuarioAdmin, int $id): array
    {
        try {
            $user = $this->gettersModel->getUserById($id);
            if ($user['status'] !== 'success') {
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
    
            $result = $this->crudModel->activateUser($id);
    
            if ($result['status'] === 'success') {
                $this->auditModel->log(
                    $idUsuarioAdmin,
                    'ACTIVAR',
                    'usuarios',
                    "Usuario ID: {$id} y registros relacionados activados correctamente"
                );
            }
    
            return $result;
        } catch (Exception $e) {
            error_log("Error en activateUser Service: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    
}
