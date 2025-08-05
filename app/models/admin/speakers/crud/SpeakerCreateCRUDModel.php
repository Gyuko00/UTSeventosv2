<?php

/**
 * Modelo para crear ponentes
 */
class SpeakerCreateCRUDModel extends Model
{
    protected ValidateSpeakerData $validateSpeakerData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validateSpeakerData = new ValidateSpeakerData();
    }

    public function createSpeaker(array $speakerData): array
    {
        try {
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = 'INSERT INTO ponentes 
                    (id_persona, tema, descripcion_biografica, especializacion, institucion_ponente)
                    VALUES (:id_persona, :tema, :descripcion_biografica, :especializacion, :institucion_ponente)';
            $this->query($sql, $speakerData);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente creado exitosamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
