<?php

/**
 * Modelo para eliminar ponentes
 */
class SpeakerDeleteCRUDModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function deleteSpeakerByPersonId(int $id_persona): array
    {
        try {
            $this->validateId($id_persona);
            $this->getDB()->beginTransaction();

            $sqlCheck = 'SELECT COUNT(*) AS count FROM ponentes WHERE id_persona = :id_persona';
            $stmt = $this->query($sqlCheck, [':id_persona' => $id_persona]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                $this->getDB()->rollBack();
                throw new InvalidArgumentException('Ponente no encontrado.');
            }

            $this->query('UPDATE ponentes SET activo = 0 WHERE id_persona = :id_persona', [':id_persona' => $id_persona]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente desactivado correctamente.'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
