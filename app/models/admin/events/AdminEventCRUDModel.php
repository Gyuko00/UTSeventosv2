<?php
/**
 * Modelo para gestionar CRUD robusto de eventos desde el administrador
 */

class AdminEventCRUDModel extends Model {

    protected ValidateEventData $validateEventData;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->validateEventData = new ValidateEventData();
    }

    public function createEvent(array $eventData) {
        try {
            $this->validateEventData->validate($eventData);

            $this->getDB()->beginTransaction();

            $sql = 'INSERT INTO eventos (titulo_evento, tema, descripcion, fecha, hora_inicio, hora_fin,
                    departamento_evento, municipio_evento, institucion_evento, lugar_detallado, cupo_maximo,
                    id_usuario_creador) VALUES (:titulo_evento, :tema, :descripcion, :fecha, :hora_inicio, :hora_fin,
                    :departamento_evento, :municipio_evento, :institucion_evento, :lugar_detallado, :cupo_maximo,
                    :id_usuario_creador)';
            $this->query($sql, $eventData);

            $this->getDB()->commit();
            return ['status' => 'success', 'message' => 'Evento creado exitosamente'];
        } catch (InvalidArgumentException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateEvent(int $id, array $eventData) {
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

    public function deleteEvent(int $id) {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = "SELECT COUNT(*) as count FROM eventos WHERE id_evento = :id";
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                throw new InvalidArgumentException('Evento no encontrado');
            }

            $this->query("DELETE FROM eventos WHERE id_evento = :id", [':id' => $id]);

            $this->getDB()->commit();
            return ['status' => 'success', 'message' => 'Evento eliminado exitosamente'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
