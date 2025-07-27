<?php

/**
 * AdminDeleteUserService: servicio para la eliminación de usuarios desde el administrador
 */

class AdminDeleteUserService extends Service {

    private AdminUserCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;
    private AdminUserGettersModel $gettersModel;
    private AdminGuestCRUDModel $guestModel;
    private AdminSpeakerCRUDModel $speakerModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->crudModel = new AdminUserCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
        $this->gettersModel = new AdminUserGettersModel($db);
        $this->guestModel = new AdminGuestCRUDModel($db);
        $this->speakerModel = new AdminSpeakerCRUDModel($db);
    }

    public function deleteUser(int $idUsuarioAdmin, int $id): array {
        $user = $this->gettersModel->getUserById($id);
        if ($user['status'] !== 'success') {
            return $user;
        }
    
        $personId = $user['data']['id_persona'];
        $idRol = (int) $user['data']['id_rol'];
    
        switch ($idRol) {
            case 3:
                $guestResult = $this->guestModel->deleteGuestByPersonId($personId);
                if ($guestResult['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'ELIMINAR',
                        'invitados',
                        "Invitado eliminado para persona ID: {$personId}"
                    );
                }
                break;
    
            case 2:
                $speakerResult = $this->speakerModel->deleteSpeakerByPersonId($personId);
                if ($speakerResult['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'ELIMINAR',
                        'ponentes',
                        "Ponente eliminado para persona ID: {$personId}"
                    );
                }
                break;
    
            case 4:
                $this->auditModel->log(
                    $idUsuarioAdmin,
                    'ELIMINAR',
                    'usuarios',
                    "Usuario control eliminado para persona ID: {$personId}"
                );
                break;
    
            default:
                return ['status' => 'error', 'message' => 'Rol desconocido o inválido'];
        }
    
        $result = $this->crudModel->deleteUser($id);
        if ($result['status'] === 'success') {
            $this->auditModel->log(
                $idUsuarioAdmin,
                'ELIMINAR',
                'usuarios',
                "Usuario ID: {$id} desactivado correctamente"
            );
        }
    
        return $result;
    }

}