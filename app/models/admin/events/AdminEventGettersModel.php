<?php

/**
 * AdminEventGettersModel: Getters del CRUD de eventos desde el administrador
 */
class AdminEventGettersModel extends Model
{
    protected EventQueryAdminModel $eventQuery;
    protected EventDetailsAdminModel $eventDetails;
    protected ScheduleCheckAdminModel $scheduleCheck;
    protected AssignmentCheckAdminModel $assignmentCheck;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventQuery = new EventQueryAdminModel($db);
        $this->eventDetails = new EventDetailsAdminModel($db);
        $this->scheduleCheck = new ScheduleCheckAdminModel($db);
        $this->assignmentCheck = new AssignmentCheckAdminModel($db);
    }

    public function getAllEvents()
    {
        return $this->eventQuery->getAllEvents();
    }

    public function getEventById(int $id): array
    {
        return $this->eventQuery->getEventById($id);
    }

    public function getEventSpeaker(int $eventoId): array
    {
        return $this->eventDetails->getEventSpeaker($eventoId);
    }

    public function getEventStats(int $eventoId): array
    {
        return $this->eventDetails->getEventStats($eventoId);
    }

    public function getEventParticipants(int $eventoId): array
    {
        return $this->eventDetails->getEventParticipants($eventoId);
    }

    public function getOccupiedTimeSlots(string $fecha, string $lugar, int $excludeEventId = null): array
    {
        return $this->scheduleCheck->getOccupiedTimeSlots($fecha, $lugar, $excludeEventId);
    }

    public function findTimeConflictingEvent(string $fecha, string $lugar, string $horaInicio, string $horaFin, int $excludeId = null): ?array
    {
        return $this->scheduleCheck->findTimeConflictingEvent($fecha, $lugar, $horaInicio, $horaFin, $excludeId);
    }

    public function hasAssignedGuestsOrSpeakers(int $idEvento): bool
    {
        return $this->assignmentCheck->hasAssignedGuestsOrSpeakers($idEvento);
    }

    public function getEventInvitees(int $eventoId): array
    {
        return $this->eventDetails->getEventInvitees($eventoId);
    }

    public function getEventInviteesStats(int $eventoId): array
    {
        return $this->eventDetails->getEventInviteesStats($eventoId);
    }
}
