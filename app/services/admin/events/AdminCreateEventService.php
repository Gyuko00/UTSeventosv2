<?php

/**
 * AdminCreateEventService: servicio para la creación de eventos desde el administrador
 */
class AdminCreateEventService extends Service
{
    private AdminEventCRUDModel $crudModel;
    private AdminAuditLogModel $auditModel;
    private AdminEventGettersModel $gettersModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crudModel = new AdminEventCRUDModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
        $this->gettersModel = new AdminEventGettersModel($db);
    }

    public function createEvent(int $idUsuarioAdmin, array $eventData): array
    {
        if (strtotime($eventData['fecha']) < strtotime(date('Y-m-d'))) {
            return ['status' => 'error', 'message' => 'No se puede crear un evento en una fecha pasada.'];
        }
    
        $conflictos = $this->gettersModel->findConflictingEvent($eventData['fecha'], $eventData['lugar_detallado']);
        if (!empty($conflictos)) {
            return ['status' => 'error', 'message' => 'Ya existe un evento programado en ese lugar y fecha.'];
        }
    
        $result = $this->crudModel->createEvent($eventData);
        if ($result['status'] === 'success') {
            $detalle = "Evento creado correctamente en fecha {$eventData['fecha']} en {$eventData['lugar_detallado']}";
            $this->auditModel->log(
                $idUsuarioAdmin,
                'CREAR',
                'eventos',
                $detalle
            );
        }
    
        return $result;
    }
    
}