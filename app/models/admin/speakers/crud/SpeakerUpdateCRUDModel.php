<?php

/**
 * Modelo para actualizar ponentes
 */
class SpeakerUpdateCRUDModel extends Model
{
    protected ValidateSpeakerData $validateSpeakerData;

    public function __construct(PDO $db)
    {
        $this->validateSpeakerData = new ValidateSpeakerData();
        parent::__construct($db);
    }

    public function updateSpeaker(int $personId, array $speakerData): array
    {
        try {
            $this->validateId($personId);
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = 'UPDATE ponentes SET
                        tema = :tema,
                        descripcion_biografica = :descripcion_biografica,
                        especializacion = :especializacion,
                        institucion_ponente = :institucion_ponente
                    WHERE id_persona = :id_persona';

            $params = [
                ':id_persona' => $personId,
                ':tema' => $speakerData['tema'] ?? '',
                ':descripcion_biografica' => $speakerData['descripcion_biografica'] ?? '',
                ':especializacion' => $speakerData['especializacion'] ?? '',
                ':institucion_ponente' => $speakerData['institucion_ponente'] ?? ''
            ];

            $result = $this->query($sql, $params);

            if ($result->rowCount() === 0) {
                $sqlInsert = 'INSERT INTO ponentes (id_persona, tema, descripcion_biografica, especializacion, institucion_ponente) 
                             VALUES (:id_persona, :tema, :descripcion_biografica, :especializacion, :institucion_ponente)';
                $this->query($sqlInsert, $params);
            }

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente actualizado exitosamente.'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
