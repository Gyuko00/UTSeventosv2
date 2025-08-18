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
        $this->gettersModel = new AdminEventGettersModel($db);
        $this->guestEventModel = new AdminEventGuestCRUDModel($db);
        $this->speakerEventModel = new AdminEventSpeakerCRUDModel($db);

        $this->createEventService = new AdminCreateEventService($db);
        $this->updateEventService = new AdminUpdateEventService($db);
        $this->deleteEventService = new AdminDeleteEventService($db);
    }

    public function getOccupiedTimeSlots(string $fecha, string $lugar, int $excludeEventId = null): array
    {
        $result = $this->gettersModel->getOccupiedTimeSlots($fecha, $lugar, $excludeEventId);

        if ($result['status'] !== 'success') {
            return ['status' => 'error', 'message' => $result['message']];
        }

        $eventos = $result['data'];
        $occupiedSlots = [];

        foreach ($eventos as $evento) {
            $slots = $this->generateSlotsFromTimeRange($evento['hora_inicio'], $evento['hora_fin']);
            $occupiedSlots = array_merge($occupiedSlots, $slots);
        }

        $occupiedSlots = array_unique($occupiedSlots);
        sort($occupiedSlots);

        return [
            'status' => 'success',
            'occupied_slots' => $occupiedSlots,
            'events_info' => $eventos
        ];
    }

    private function generateSlotsFromTimeRange(string $horaInicio, string $horaFin): array
    {
        $slots = [];
        $current = new DateTime('1970-01-01 ' . $horaInicio);
        $end = new DateTime('1970-01-01 ' . $horaFin);

        while ($current < $end) {
            $slots[] = $current->format('H:i');
            $current->add(new DateInterval('PT30M'));
        }

        return $slots;
    }

    public function createEvent(array $eventData): array
    {
        return $this->createEventService->createEvent($eventData);
    }

    public function updateEvent(int $idUsuarioAdmin, int $id, array $eventData): array
    {
        return $this->updateEventService->updateEvent($idUsuarioAdmin, $id, $eventData);
    }

    public function deleteEvent(int $idUsuarioAdmin, int $id): array
    {
        return $this->deleteEventService->deleteEvent($idUsuarioAdmin, $id);
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

    public function getEventInvitees(int $eventoId): array
    {
        try {
            $result = $this->gettersModel->getEventInvitees($eventoId);
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getEventInviteesStats(int $eventoId): array
    {

        try {
            $result = $this->gettersModel->getEventInviteesStats($eventoId);
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getEventCompleteStats(int $eventoId): array
    {
        try {
            // Obtener estadísticas existentes de ponentes
            $ponentesStats = $this->getEventStats($eventoId);

            // Obtener estadísticas de invitados
            $invitadosStats = $this->getEventInviteesStats($eventoId);

            if ($ponentesStats['status'] !== 'success' || $invitadosStats['status'] !== 'success') {
                return [
                    'status' => 'error',
                    'message' => 'Error al obtener estadísticas completas del evento'
                ];
            }

            return [
                'status' => 'success',
                'data' => [
                    'ponentes' => $ponentesStats['data'],
                    'invitados' => $invitadosStats['data']
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener estadísticas completas: ' . $e->getMessage()
            ];
        }
    }
}
