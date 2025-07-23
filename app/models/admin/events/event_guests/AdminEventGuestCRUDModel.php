<?php

/**
 * AdminEventGuestCRUDModel: CRUD de invitados asignados a eventos
 */
class AdminEventGuestCRUDModel extends Model {

    protected ValidateEventGuestData $validator;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->validator = new ValidateEventGuestData();
    }

    public function addGuestToEvent(array $data): array {
        try {
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = "INSERT INTO invitados_evento 
                    (id_persona, id_evento, token, estado_asistencia,
                    fecha_inscripcion, certificado_generado) 
                    VALUES 
                    (:id_persona, :id_evento, :token, :estado_asistencia,
                    :fecha_inscripcion, :certificado_generado)";

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Invitado asignado al evento correctamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateGuestEvent(int $id, array $data): array {
        try {
            $this->validateId($id);
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = "UPDATE invitados_evento SET 
                        id_persona = :id_persona,
                        id_evento = :id_evento,
                        token = :token,
                        estado_asistencia = :estado_asistencia,
                        fecha_inscripcion = :fecha_inscripcion,
                        certificado_generado = :certificado_generado
                    WHERE id_invitado_evento = :id";

            $data['id'] = $id;

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de invitado actualizado correctamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteGuestEvent(int $id): array {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = "SELECT COUNT(*) AS count FROM invitados_evento WHERE id_invitado_evento = :id";
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count === 0) {
                throw new InvalidArgumentException('Registro no encontrado.');
            }

            $this->query("DELETE FROM invitados_evento WHERE id_invitado_evento = :id", [':id' => $id]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de invitado eliminado correctamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
