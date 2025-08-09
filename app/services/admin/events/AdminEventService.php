<?php

/**
 * AdminEventService: servicio para gestión de eventos desde el administrador.
 * 
 * Incluye lógica para validar dependencias antes de eliminar.
 */
class AdminEventService
{
    private AdminEventGettersModel $gettersModel;
    private AdminEventGuestCRUDModel $guestEventModel;
    private AdminEventSpeakerCRUDModel $speakerEventModel;

    private AdminCreateEventService $createEventService;
    private AdminUpdateEventService $updateEventService;
    private AdminDeleteEventService $deleteEventService;

    public function __construct(PDO $db)
    {
        $this->gettersModel     = new AdminEventGettersModel($db);
        $this->guestEventModel  = new AdminEventGuestCRUDModel($db);
        $this->speakerEventModel = new AdminEventSpeakerCRUDModel($db);

        $this->createEventService = new AdminCreateEventService($db);
        $this->updateEventService = new AdminUpdateEventService($db);
        $this->deleteEventService = new AdminDeleteEventService($db);
    }

    public function createEvent(array $eventData): array
    {
        return $this->createEventService->createEvent($eventData);
    }

    public function updateEvent(int $id, array $eventData): array
    {
        return $this->updateEventService->updateEvent($id, $eventData);
    }


    public function deleteEvent(int $id): array
    {
        return $this->deleteEventService->deleteEvent($id);
    }

    public function getAllEvents(): array
    {
        return $this->gettersModel->getAllEvents();
    }

    public function getEventById(int $id): array
    {
        return $this->gettersModel->getEventById($id);
    }
    
    public function getEventSpeaker(int $eventoId): array
    {
        return $this->gettersModel->getEventSpeaker($eventoId);
    }
    
    public function getEventStats(int $eventoId): array
    {
        return $this->gettersModel->getEventStats($eventoId);
    }
    
    public function getEventParticipants(int $eventoId): array
    {
        return $this->gettersModel->getEventParticipants($eventoId);
    }

}
