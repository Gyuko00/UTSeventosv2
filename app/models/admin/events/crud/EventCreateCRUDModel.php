<?php

/**
 * Modelo para crear eventos
 */
class EventCreateCRUDModel extends Model
{
    protected ValidateEventData $validateEventData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validateEventData = new ValidateEventData();
    }

    public function createEvent(array $eventData)
    {
        try {
            if (!$this->validateEventData) {
                throw new Exception('validateEventData no está inicializado');
            }
    
            $required = ['titulo_evento', 'fecha', 'lugar_detallado', 'hora_inicio', 'hora_fin', 'id_usuario_creador'];
            foreach ($required as $f) {
                if (!isset($eventData[$f]) || $eventData[$f] === '') {
                    throw new InvalidArgumentException("Falta el campo requerido: $f");
                }
            }
    
            if (strtotime($eventData['hora_fin']) <= strtotime($eventData['hora_inicio'])) {
                throw new InvalidArgumentException('La hora de fin debe ser posterior a la hora de inicio');
            }
    
            $this->validateEventData->validate($eventData);
    
            $params = [
                ':titulo_evento'       => (string) $eventData['titulo_evento'],
                ':tema'                => (string) ($eventData['tema'] ?? ''),
                ':descripcion'         => (string) ($eventData['descripcion'] ?? ''),
                ':fecha'               => (string) $eventData['fecha'],
                ':hora_inicio'         => (string) $eventData['hora_inicio'],
                ':hora_fin'            => (string) $eventData['hora_fin'],
                ':departamento_evento' => (string) ($eventData['departamento_evento'] ?? ''),
                ':municipio_evento'    => (string) ($eventData['municipio_evento'] ?? ''),
                ':institucion_evento'  => (string) ($eventData['institucion_evento'] ?? ''),
                ':lugar_detallado'     => (string) $eventData['lugar_detallado'],
                ':cupo_maximo'         => (int)    ($eventData['cupo_maximo'] ?? 0),
                ':id_usuario_creador'  => (int)    $eventData['id_usuario_creador'],
            ];
    
            $db = $this->getDB();
            if (!$db) {
                throw new Exception('getDB() retornó null');
            }
    
            $db->beginTransaction();
    
            $sql = 'INSERT INTO eventos (
                        titulo_evento, tema, descripcion, fecha, hora_inicio, hora_fin,
                        departamento_evento, municipio_evento, institucion_evento,
                        lugar_detallado, cupo_maximo, id_usuario_creador
                    ) VALUES (
                        :titulo_evento, :tema, :descripcion, :fecha, :hora_inicio, :hora_fin,
                        :departamento_evento, :municipio_evento, :institucion_evento,
                        :lugar_detallado, :cupo_maximo, :id_usuario_creador
                    )';
    
            $this->query($sql, $params);
    
            $newId = (int) $db->lastInsertId();
            $db->commit();
    
            return [
                'status'    => 'success',
                'message'   => 'Evento creado exitosamente',
                'id_evento' => $newId,
            ];
        } catch (InvalidArgumentException $e) {
            if ($this->getDB() && $this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        } catch (Exception $e) {
            if ($this->getDB() && $this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => 'Error interno: ' . $e->getMessage()];
        }
    }
}    
