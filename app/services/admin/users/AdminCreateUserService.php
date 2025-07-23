<?php

/**
 * AdminCreateUserService: servicio para la creación de usuarios desde el administrador
 */
class AdminCreateUserService extends Service
{
    private AdminUserCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crudModel = new AdminUserCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
    }

    public function createUserWithRole(int $idUsuarioAdmin, array $personData, array $userData, array $roleSpecificData = []): array
    {
        $result = $this->crudModel->createUser($personData, $userData);
        if ($result['status'] !== 'success') {
            return $result;
        }

        $user = $this->gettersModel->getUserByUsername($userData['usuario']);
        if ($user['status'] !== 'success') {
            return $user;
        }

        $personId = $user['data']['id_persona'];
        $roleSpecificData['id_persona'] = $personId;

        switch ((int) $userData['id_rol']) {
            case 3:
                $result = $this->guestModel->createGuest($roleSpecificData);
                if ($result['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'CREAR',
                        'invitados',
                        "Invitado creado para persona ID: {$personId}"
                    );
                }
                break;

            case 2:
                $result = $this->speakerModel->createSpeaker($roleSpecificData);
                if ($result['status'] === 'success') {
                    $this->auditModel->log(
                        $idUsuarioAdmin,
                        'CREAR',
                        'ponentes',
                        "Ponente creado para persona ID: {$personId}"
                    );
                }
                break;

            case 4:
                $result = ['status' => 'success', 'message' => 'Usuario control creado correctamente'];
                $this->auditModel->log(
                    $idUsuarioAdmin,
                    'CREAR',
                    'usuarios',
                    "Usuario control creado para persona ID: {$personId}"
                );
                break;

            default:
                return ['status' => 'error', 'message' => 'Rol desconocido o inválido'];
        }

        return $result;
    }
}
