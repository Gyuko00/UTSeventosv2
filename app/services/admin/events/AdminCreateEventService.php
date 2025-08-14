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

    public function createEvent(array $eventData): array
    {
        try {
            $required = ['titulo_evento', 'fecha', 'lugar_detallado', 'id_usuario_creador'];
            foreach ($required as $field) {
                if (!isset($eventData[$field])) {
                    throw new InvalidArgumentException("Falta el campo requerido: $field");
                }
            }
    
            $conflicto = $this->gettersModel->findConflictingEvent(
                $eventData['fecha'],
                $eventData['lugar_detallado']
            );
    
            if ($conflicto !== null) {
                throw new InvalidArgumentException('Ya existe un evento en esa fecha/lugar');
            }
    
            $result = $this->crudModel->createEvent($eventData);
            
            if (($result['status'] ?? '') !== 'success') {
                return $result;
            }
            
            $this->auditModel->log(
                (int)$eventData['id_usuario_creador'],
                'CREAR',
                'eventos',
                "Evento creado: " . substr($eventData['titulo_evento'], 0, 100)
            );
            

            return $result;
    
        } catch (InvalidArgumentException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error interno'];
        }
    }
}
