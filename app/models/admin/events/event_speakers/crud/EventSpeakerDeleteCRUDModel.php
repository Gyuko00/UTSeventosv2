<?php
/**
 * Modelo para eliminar ponentes a los eventos
 */
class EventSpeakerDeleteCRUDModel extends Model
{
    public function deleteSpeakerEvent(int $id): array
    {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = 'SELECT COUNT(*) AS count FROM ponentes_evento WHERE id_ponente_evento = :id';
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                throw new InvalidArgumentException('Registro no encontrado.');
            }

            $this->query('DELETE FROM ponentes_evento WHERE id_ponente_evento = :id', [':id' => $id]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de ponente en evento eliminado.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
