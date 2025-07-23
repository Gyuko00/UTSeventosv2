<?php

/**
 * AdminUpdateUserService: servicio para la actualización de usuarios desde el administrador
 */
class AdminUpdateUserService extends Service
{
    private AdminUserCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crudModel = new AdminUserCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
    }

    public function updateUserWithRole(int $idUsuarioAdmin, int $id, array $personData, array $userData, array $roleSpecificData = []): array
    {
        $result = $this->crudModel->updateUser($id, $personData, $userData);
        if ($result['status'] !== 'success') {
            return $result;
        }

        $user = $this->gettersModel->getUserById($id);
        if ($user['status'] !== 'success') {
            return $user;
        }

        $personId = $user['data']['id_persona'];
        $roleSpecificData['id_persona'] = $personId;

        switch ((int) $userData['id_rol']) {
            case 3:
                $result = $this->guestModel->updateGuest($personId, $roleSpecificData);
                if ($result['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'ACTUALIZAR',
                        'invitados',
                        "Invitado actualizado para persona ID: {$personId}"
                    );
                }
                break;

            case 2:
                $result = $this->speakerModel->updateSpeaker($personId, $roleSpecificData);
                if ($result['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'ACTUALIZAR',
                        'ponentes',
                        "Ponente actualizado para persona ID: {$personId}"
                    );
                }
                break;

            case 4:
                $result = ['status' => 'success', 'message' => 'Usuario control actualizado correctamente'];
                $this->auditModel->log(
                    $idUsuarioAdmin,
                    'ACTUALIZAR',
                    'usuarios',
                    "Usuario control actualizado para persona ID: {$personId}"
                );
                break;

            default:
                return ['status' => 'error', 'message' => 'Rol desconocido o inválido'];
        }

        return $result;
    }
}
