<?php

/**
 * Modelo para eliminar invitados a los eventos
 */
class EventGuestDeleteCRUDModel extends Model
{
    public function deleteGuestEvent(int $id): array
    {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = 'SELECT COUNT(*) AS count FROM invitados_evento WHERE id_invitado_evento = :id';
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count === 0) {
                throw new InvalidArgumentException('Registro no encontrado.');
            }

            $this->query('DELETE FROM invitados_evento WHERE id_invitado_evento = :id', [':id' => $id]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de invitado eliminado correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
