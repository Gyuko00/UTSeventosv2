<?php

/**
 * AdminSpeakerModel: CRUD de ponentes desde el administrador
 */
class AdminSpeakerCRUDModel extends Model {

    protected ValidateSpeakerData $validateSpeakerData;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->validateSpeakerData = new ValidateSpeakerData();
    }

    public function createSpeaker(array $speakerData): array {
        try {
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = "INSERT INTO ponentes 
                    (id_persona, tema, descripcion_biografica, especializacion, institucion_ponente)
                    VALUES (:id_persona, :tema, :descripcion_biografica, :especializacion, :institucion_ponente)";
            $this->query($sql, $speakerData);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente creado exitosamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateSpeaker(int $id, array $speakerData): array {
        try {
            $this->validateId($id);
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = "UPDATE ponentes SET 
                        id_persona = :id_persona,
                        tema = :tema,
                        descripcion_biografica = :descripcion_biografica,
                        especializacion = :especializacion,
                        institucion_ponente = :institucion_ponente
                    WHERE id_ponente = :id";

            $speakerData['id'] = $id;

            $this->query($sql, $speakerData);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente actualizado exitosamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteSpeakerByPersonId(int $id_persona): array {
        try {
            $this->validateId($id_persona);

            $this->getDB()->beginTransaction();

            $sqlCheck = "SELECT COUNT(*) AS count FROM ponentes WHERE id_persona = :id_persona";
            $stmt = $this->query($sqlCheck, [':id_persona' => $id_persona]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            if ($count == 0) {
                throw new InvalidArgumentException('Ponente no encontrado.');
            }

            $this->query("DELETE FROM ponentes WHERE id_persona = :id_persona", [':id_persona' => $id_persona]);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente eliminado exitosamente.'];

        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
