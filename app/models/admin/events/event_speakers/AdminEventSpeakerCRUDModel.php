<?php

/**
 * AdminEventSpeakerCRUDModel: CRUD de ponentes asignados a eventos
 */
class AdminEventSpeakerCRUDModel extends Model {

    protected ValidateEventSpeakerData $validator;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->validator = new ValidateEventSpeakerData();
    }

    public function addSpeakerToEvent(array $data): array {
        try {
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = "INSERT INTO ponentes_evento 
                    (id_ponente, id_evento, hora_participacion, estado_asistencia, certificado_generado, fecha_registro) 
                    VALUES 
                    (:id_ponente, :id_evento, :hora_participacion, :estado_asistencia, :certificado_generado, :fecha_registro)";

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente asignado al evento correctamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateSpeakerEvent(int $id, array $data): array {
        try {
            $this->validateId($id);
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = "UPDATE ponentes_evento SET 
                        id_ponente = :id_ponente,
                        id_evento = :id_evento,
                        hora_participacion = :hora_participacion,
                        estado_asistencia = :estado_asistencia,
                        certificado_generado = :certificado_generado,
                        fecha_registro = :fecha_registro
                    WHERE id_ponente_evento = :id";

            $data['id'] = $id;

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de ponente en evento actualizado.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteSpeakerEvent(int $id): array {
        try {
            $this->validateId($id);

            $this->getDB()->beginTransaction();

            $sqlCheck = "SELECT COUNT(*) AS count FROM ponentes_evento WHERE id_ponente_evento = :id";
            $stmt = $this->query($sqlCheck, [':id' => $id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                throw new InvalidArgumentException('Registro no encontrado.');
            }

            $this->query("DELETE FROM ponentes_evento WHERE id_ponente_evento = :id", [':id' => $id]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de ponente en evento eliminado.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
