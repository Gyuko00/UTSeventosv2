<?php

/**
 * AdminDeleteEventService: servicio para la eliminación de eventos desde el administrador
 */
class AdminDeleteEventService extends Service {
    
    private AdminEventCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;
    private AdminEventGettersModel $gettersModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->crudModel = new AdminEventCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
        $this->gettersModel = new AdminEventGettersModel($db);
    }

    public function deleteEvent(int $idUsuarioAdmin, int $id): array
    {
        $existe = $this->gettersModel->getEventById($id);
        if ($existe['status'] !== 'success') {
            return ['status' => 'error', 'message' => 'El evento a eliminar no existe.'];
        }
    
        if ($this->gettersModel->hasAssignedGuestsOrSpeakers($id)) {
            return ['status' => 'error', 'message' => 'No se puede eliminar un evento con invitados o ponentes asignados.'];
        }
    
        $result = $this->crudModel->deleteEvent($id);
        if ($result['status'] === 'success') {
            $detalle = "Evento ID: {$id} eliminado correctamente";
            $this->auditModel->log(
                $idUsuarioAdmin,
                'ELIMINAR',
                'eventos',
                $detalle
            );
        }
    
        return $result;
    }

}
