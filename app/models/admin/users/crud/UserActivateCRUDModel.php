<?php

/**
 * Modelo para activación de usuarios
 */
class UserActivateCRUDModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function activateUser(int $id): array
    {
        try {
            $this->validateId($id);
            $this->getDB()->beginTransaction();

            $sqlGetPerson = 'SELECT id_persona, id_rol FROM usuarios WHERE id_usuario = :id';
            $stmt = $this->query($sqlGetPerson, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->getDB()->rollBack();
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            $personId = (int) $row['id_persona'];
            $rol = (int) $row['id_rol'];

            $this->query('UPDATE usuarios SET activo = 1 WHERE id_usuario = :id', [':id' => $id]);
            $this->query('UPDATE personas SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);

            if ($rol === 3) {
                $this->query('UPDATE invitados SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);
            } elseif ($rol === 2) {
                $this->query('UPDATE ponentes SET activo = 1 WHERE id_persona = :person_id', [':person_id' => $personId]);
            }

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Usuario y registros relacionados activados correctamente'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            error_log('Error en activateUser Model: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
