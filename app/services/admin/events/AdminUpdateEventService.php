<?php

/**
 * AdminUpdateEventService: servicio para la actualización de eventos desde el administrador
 */

class AdminUpdateEventService extends Service {
    private AdminEventCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;
    private AdminEventGettersModel $gettersModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->crudModel = new AdminEventCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
        $this->gettersModel = new AdminEventGettersModel($db);
    }

    public function updateEvent(int $idUsuarioAdmin, int $id, array $eventData): array
    {
        $existe = $this->gettersModel->getEventById($id);
        if ($existe['status'] !== 'success') {
            return ['status' => 'error', 'message' => 'El evento a actualizar no existe.'];
        }
    
        if (strtotime($eventData['fecha']) < strtotime(date('Y-m-d'))) {
            return ['status' => 'error', 'message' => 'No se puede programar un evento en una fecha pasada.'];
        }
    
        $conflictos = $this->gettersModel->findConflictingEvent($eventData['fecha'], $eventData['lugar_detallado'], $id);
        if (!empty($conflictos)) {
            return ['status' => 'error', 'message' => 'Ya existe otro evento en ese lugar y fecha.'];
        }
    
        $result = $this->crudModel->updateEvent($id, $eventData);
        if ($result['status'] === 'success') {
            $detalle = "Evento ID: {$id} actualizado correctamente para la fecha {$eventData['fecha']} en {$eventData['lugar_detallado']}";
            $this->auditModel->log(
                $idUsuarioAdmin,
                'ACTUALIZAR',
                'eventos',
                $detalle
            );
        }
    
        return $result;
    }
    
}