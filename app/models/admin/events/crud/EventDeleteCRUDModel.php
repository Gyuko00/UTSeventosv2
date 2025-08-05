<?php
/**
 * Modelo para eliminar eventos
 */
class EventDeleteCRUDModel extends Model
{

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function deleteEvent(int $id)
    {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = 'SELECT COUNT(*) as count FROM eventos WHERE id_evento = :id';
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                throw new InvalidArgumentException('Evento no encontrado');
            }

            $this->query('DELETE FROM eventos WHERE id_evento = :id', [':id' => $id]);

            $this->getDB()->commit();
            return ['status' => 'success', 'message' => 'Evento eliminado exitosamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}