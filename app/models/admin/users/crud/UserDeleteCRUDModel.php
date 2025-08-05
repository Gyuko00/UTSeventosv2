<?php

/**
 * Modelo para desactivar usuarios
 */
class UserDeleteCRUDModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function deleteUser(int $id): array
    {
        try {
            $this->validateId($id);
            $this->getDB()->beginTransaction();

            $sqlGetPerson = 'SELECT id_persona FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            $id_persona = (int) $row['id_persona'];

            $this->query('UPDATE usuarios SET activo = 0 WHERE id_usuario = :id', [':id' => $id]);

            $this->query('UPDATE personas SET activo = 0 WHERE id_persona = :id_persona', [':id_persona' => $id_persona]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario y persona desactivados correctamente'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
