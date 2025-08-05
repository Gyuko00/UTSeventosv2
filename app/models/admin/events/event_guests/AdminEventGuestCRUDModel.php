<?php

/**
 * AdminEventGuestCRUDModel: CRUD de invitados asignados a eventos
 */
class AdminEventGuestCRUDModel extends Model
{
    protected EventGuestCreateCRUDModel $eventGuestCreateCRUDModel;
    protected EventGuestUpdateCRUDModel $eventGuestUpdateCRUDModel;
    protected EventGuestDeleteCRUDModel $eventGuestDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventGuestCreateCRUDModel = new EventGuestCreateCRUDModel($db);
        $this->eventGuestUpdateCRUDModel = new EventGuestUpdateCRUDModel($db);
        $this->eventGuestDeleteCRUDModel = new EventGuestDeleteCRUDModel($db);
    }

    public function addGuestToEvent(array $data): array
    {
        $this->eventGuestCreateCRUDModel->addGuestToEvent($data);
    }

    public function updateGuestEvent(int $id, array $data): array
    {
        $this->eventGuestUpdateCRUDModel->updateGuestEvent($id, $data);
    }

    public function deleteGuestEvent(int $id): array
    {
        $this->eventGuestDeleteCRUDModel->deleteGuestEvent($id);
    }
}
