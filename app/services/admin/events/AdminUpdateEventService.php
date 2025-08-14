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
        
        if (isset($eventData['hora_inicio'], $eventData['hora_fin'])) {
            if (strtotime($eventData['hora_inicio']) >= strtotime($eventData['hora_fin'])) {
                return ['status' => 'error', 'message' => 'La hora de inicio debe ser anterior a la hora de finalización.'];
            }
        }
        
        $conflictos = $this->gettersModel->findTimeConflictingEvent(
            $eventData['fecha'], 
            $eventData['lugar_detallado'], 
            $eventData['hora_inicio'], 
            $eventData['hora_fin'], 
            $id
        );
        
        if (!empty($conflictos)) {
            $eventoConflicto = $conflictos[0];
            $mensaje = sprintf(
                'Ya existe el evento "%s" programado para el %s de %s a %s en %s.',
                $eventoConflicto['titulo_evento'],
                date('d/m/Y', strtotime($eventData['fecha'])),
                date('H:i', strtotime($eventoConflicto['hora_inicio'])),
                date('H:i', strtotime($eventoConflicto['hora_fin'])),
                $eventData['lugar_detallado']
            );
            return ['status' => 'error', 'message' => $mensaje];
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