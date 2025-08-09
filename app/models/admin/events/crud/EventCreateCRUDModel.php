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

            $this->validateEventData->validate($eventData);

            $db = $this->getDB();
            if (!$db) {
                throw new Exception('getDB() retornó null');
            }

            $db->beginTransaction();

            $sql = 'INSERT INTO eventos (titulo_evento, tema, descripcion, fecha, hora_inicio, hora_fin,
                departamento_evento, municipio_evento, institucion_evento, lugar_detallado, cupo_maximo,
                id_usuario_creador) VALUES (:titulo_evento, :tema, :descripcion, :fecha, :hora_inicio, :hora_fin,
                :departamento_evento, :municipio_evento, :institucion_evento, :lugar_detallado, :cupo_maximo,
                :id_usuario_creador)';

            $this->query($sql, $eventData);

            $db->commit();
            return ['status' => 'success', 'message' => 'Evento creado exitosamente'];
        } catch (InvalidArgumentException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        } catch (Exception $e) {
            if ($this->getDB() && $this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
