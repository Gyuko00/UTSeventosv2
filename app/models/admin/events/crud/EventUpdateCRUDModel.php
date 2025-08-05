<?php
/**
 * Modelo para actualizar eventos
 */
class EventUpdateCRUDModel extends Model
{
    protected ValidateEventData $validateEventData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validateEventData = new ValidateEventData();
    }

    public function updateEvent(int $id, array $eventData)
    {
        try {
            $this->validateId($id);

            $this->validateEventData->validate($eventData);

            $this->getDB()->beginTransaction();

            $sql = 'UPDATE eventos SET titulo_evento = :titulo_evento, tema = :tema, 
                    descripcion = :descripcion, fecha = :fecha, hora_inicio = :hora_inicio, 
                    hora_fin = :hora_fin, departamento_evento = :departamento_evento, 
                    municipio_evento = :municipio_evento, institucion_evento = :institucion_evento, 
                    lugar_detallado = :lugar_detallado, cupo_maximo = :cupo_maximo,
                    id_usuario_creador = :id_usuario_creador WHERE id_evento = :id';

            $eventData['id'] = $id;

            $this->query($sql, $eventData);

            $this->getDB()->commit();
            return ['status' => 'success', 'message' => 'Evento actualizado exitosamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}