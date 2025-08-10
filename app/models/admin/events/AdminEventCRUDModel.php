<?php

/**
 * Modelo para gestionar CRUD robusto de eventos desde el administrador
 */
class AdminEventCRUDModel extends Model
{
    protected EventCreateCRUDModel $eventCreateCRUDModel;
    protected EventUpdateCRUDModel $eventUpdateCRUDModel;
    protected EventDeleteCRUDModel $eventDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventCreateCRUDModel = new EventCreateCRUDModel($db);
        $this->eventUpdateCRUDModel = new EventUpdateCRUDModel($db);
        $this->eventDeleteCRUDModel = new EventDeleteCRUDModel($db);
    }

    public function createEvent(array $eventData)
    {
        return $this->eventCreateCRUDModel->createEvent($eventData);
    }

    public function updateEvent(int $id, array $eventData)
    {
        return $this->eventUpdateCRUDModel->updateEvent($id, $eventData);
    }

    public function deleteEvent(int $id): array
    {
        return $this->eventDeleteCRUDModel->deleteEvent($id);
    }
}
