<?php

/**
 * AdminEventSpeakerCRUDModel: CRUD de ponentes asignados a eventos
 */
class AdminEventSpeakerCRUDModel extends Model
{
    protected EventSpeakerCreateCRUDModel $eventSpeakerCreateCRUDModel;
    protected EventSpeakerUpdateCRUDModel $eventSpeakerUpdateCRUDModel;
    protected EventSpeakerDeleteCRUDModel $eventSpeakerDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventSpeakerCreateCRUDModel = new EventSpeakerCreateCRUDModel($db);
        $this->eventSpeakerUpdateCRUDModel = new EventSpeakerUpdateCRUDModel($db);
        $this->eventSpeakerDeleteCRUDModel = new EventSpeakerDeleteCRUDModel($db);
    }

    public function addSpeakerToEvent(array $data): array
    {
        $this->eventSpeakerCreateCRUDModel->addSpeakerToEvent($data);
    }

    public function updateSpeakerEvent(int $id, array $data): array
    {
        $this->eventSpeakerUpdateCRUDModel->updateSpeakerEvent($id, $data);
    }

    public function deleteSpeakerEvent(int $id): array
    {
        $this->eventSpeakerDeleteCRUDModel->deleteSpeakerEvent($id);
    }
}
