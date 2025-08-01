<?php

/**
 * AdminUpdateUserService: servicio para la actualización de usuarios desde el administrador
 */
class AdminUpdateUserService extends Service
{
    private AdminUserCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;
    private AdminUserGettersModel $userGettersModel;
    private AdminGuestGettersModel $guestGettersModel;
    private AdminSpeakerGettersModel $speakerGettersModel;
    private AdminGuestCRUDModel $guestModel;
    private AdminSpeakerCRUDModel $speakerModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crudModel = new AdminUserCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
        $this->userGettersModel = new AdminUserGettersModel($db);
        $this->guestGettersModel = new AdminGuestGettersModel($db);
        $this->speakerGettersModel = new AdminSpeakerGettersModel($db);
        $this->guestModel = new AdminGuestCRUDModel($db);
        $this->speakerModel = new AdminSpeakerCRUDModel($db);
    }

    public function updateUserWithRole(int $idUsuarioAdmin, int $id, array $personData, array $userData, array $roleSpecificData = []): array 
    {
        $result = $this->crudModel->updateUser($id, $personData, $userData);
        if ($result['status'] !== 'success') {
            return $result;
        }
    
        $user = $this->userGettersModel->getUserById($id);
        if ($user['status'] !== 'success') {
            return $user;
        }
    
        $personId = $user['data']['id_persona'];
        $roleSpecificData['id_persona'] = $personId;
    
        $oldRoleId = (int)$user['data']['id_rol'];
        $newRoleId = (int)$userData['id_rol'];
    
        if ($oldRoleId !== $newRoleId && $this->hasRoleSpecificData($personId, $oldRoleId)) {
            return [
                'status' => 'error', 
                'message' => 'No se puede cambiar el rol de un usuario que ya tiene información específica. Para cambiar el rol, debe eliminar el usuario y crear uno nuevo.',
                'code' => 'ROLE_CHANGE_BLOCKED'
            ];
        }
    
        if ($oldRoleId !== $newRoleId) {
            switch ($oldRoleId) {
                case 2:
                    $this->speakerModel->deleteSpeaker($personId);
                    $this->auditModel->log($idUsuarioAdmin, 'ELIMINAR', 'ponentes', "Ponente eliminado para persona ID: {$personId}");
                    break;
                case 3:
                    $this->guestModel->deleteGuest($personId);
                    $this->auditModel->log($idUsuarioAdmin, 'ELIMINAR', 'invitados', "Invitado eliminado para persona ID: {$personId}");
                    break;
            }
        }
    
        switch ($newRoleId) {
            case 3:
                if (!$this->validateGuestRequiredFields($roleSpecificData)) {
                    return [
                        'status' => 'error', 
                        'message' => 'Faltan campos obligatorios para el rol de invitado. El tipo de invitado es requerido.',
                        'code' => 'MISSING_GUEST_FIELDS'
                    ];
                }
    
                $filteredData = array_filter($roleSpecificData, function($value, $key) {
                    if ($key === 'id_persona') return true;
                    return $value !== null && $value !== '';
                }, ARRAY_FILTER_USE_BOTH);
    
                $guest = $this->guestGettersModel->getGuestByPersonId($personId);
                if ($guest['status'] !== 'success') {
                    $result = $this->guestModel->createGuest($filteredData);
                    if ($result['status'] !== 'success') return $result;
                    $this->auditModel->log($idUsuarioAdmin, 'CREAR', 'invitados', "Invitado creado para persona ID: {$personId}");
                } else {
                    $result = $this->guestModel->updateGuest($personId, $roleSpecificData);
                    if ($result['status'] === 'success') {
                        $this->auditModel->log($idUsuarioAdmin, 'ACTUALIZAR', 'invitados', "Invitado actualizado para persona ID: {$personId}");
                    }
                }
                break;
    
            case 2:
                if (!$this->validateSpeakerRequiredFields($roleSpecificData)) {
                    return [
                        'status' => 'error', 
                        'message' => 'Faltan campos obligatorios para el rol de ponente. El tema y la descripción biográfica son requeridos.',
                        'code' => 'MISSING_SPEAKER_FIELDS'
                    ];
                }
    
                $filteredData = array_filter($roleSpecificData, function($value, $key) {
                    if ($key === 'id_persona') return true;
                    return $value !== null && $value !== '';
                }, ARRAY_FILTER_USE_BOTH);
    
                $speaker = $this->speakerGettersModel->getSpeakerByPersonId($personId);
                if ($speaker['status'] !== 'success') {
                    $result = $this->speakerModel->createSpeaker($filteredData);
                    if ($result['status'] !== 'success') return $result;
                    $this->auditModel->log($idUsuarioAdmin, 'CREAR', 'ponentes', "Ponente creado para persona ID: {$personId}");
                } else {
                    $result = $this->speakerModel->updateSpeaker($personId, $roleSpecificData);
                    if ($result['status'] === 'success') {
                        $this->auditModel->log($idUsuarioAdmin, 'ACTUALIZAR', 'ponentes', "Ponente actualizado para persona ID: {$personId}");
                    }
                }
                break;
    
            case 4:
                $result = ['status' => 'success', 'message' => 'Usuario de control actualizado correctamente'];
                $this->auditModel->log($idUsuarioAdmin, 'ACTUALIZAR', 'usuarios', "Usuario control actualizado para persona ID: {$personId}");
                break;
    
            default:
                return ['status' => 'error', 'message' => 'Rol desconocido o inválido'];
        }
    
        return $result;
    }

    private function hasRoleSpecificData(int $personId, int $roleId): bool
    {
        switch ($roleId) {
            case 2:
                $speaker = $this->speakerGettersModel->getSpeakerByPersonId($personId);
                return $speaker['status'] === 'success' && !empty($speaker['data']);
                
            case 3:
                $guest = $this->guestGettersModel->getGuestByPersonId($personId);
                return $guest['status'] === 'success' && !empty($guest['data']);
                
            default:
                return false;
        }
    }

    private function validateGuestRequiredFields(array $data): bool
    {
        return !empty($data['tipo_invitado']);
    }

    private function validateSpeakerRequiredFields(array $data): bool
    {
        return !empty($data['tema']) && !empty($data['descripcion_biografica']);
    }
    
}
