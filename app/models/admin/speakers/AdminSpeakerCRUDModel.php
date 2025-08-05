<?php

/**
 * AdminSpeakerModel: CRUD de ponentes desde el administrador
 */
class AdminSpeakerCRUDModel extends Model
{
    protected SpeakerCreateCRUDModel $speakerCreateCRUDModel;
    protected SpeakerUpdateCRUDModel $speakerUpdateCRUDModel;
    protected SpeakerDeleteCRUDModel $speakerDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->speakerCreateCRUDModel = new SpeakerCreateCRUDModel($db);
        $this->speakerUpdateCRUDModel = new SpeakerUpdateCRUDModel($db);
        $this->speakerDeleteCRUDModel = new SpeakerDeleteCRUDModel($db);
    }

    public function createSpeaker(array $speakerData): array
    {
       return $this->speakerCreateCRUDModel->createSpeaker($speakerData);
    }

    public function updateSpeaker(int $personId, array $speakerData): array
    {
        return $this->speakerUpdateCRUDModel->updateSpeaker($personId, $speakerData);
    }

    public function deleteSpeakerByPersonId(int $id_persona): array
    {
        return $this->speakerDeleteCRUDModel->deleteSpeakerByPersonId($id_persona);
    }
}
