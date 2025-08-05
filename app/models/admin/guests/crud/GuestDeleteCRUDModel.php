<?php

/**
 * Modelo para eliminar invitados
 */
class GuestDeleteCRUDModel extends Model
{
    protected ValidateAdminGuestData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateAdminGuestData();
    }

    public function deleteGuestByPersonId(int $id_persona): array
    {
        try {
            $this->validateId($id_persona);
            $this->getDB()->beginTransaction();

            $sqlCheck = 'SELECT COUNT(*) AS count FROM invitados WHERE id_persona = :id_persona';
            $stmt = $this->query($sqlCheck, [':id_persona' => $id_persona]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                $this->getDB()->rollBack();
                throw new InvalidArgumentException('Invitado no encontrado.');
            }

            $sql = 'UPDATE invitados SET activo = 0 WHERE id_persona = :id_persona';
            $this->query($sql, [':id_persona' => $id_persona]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Invitado desactivado correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
