<?php

/**
 * AdminEventGuestService: servicio para la gestión de invitados en eventos desde el administrador
 */
class AdminEventGuestService extends Service
{
    private AdminEventGuestCRUDModel $eventGuestModel;
    private AdminEventGuestGettersModel $gettersModel;
    private AdminAuditLogModel $auditModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventGuestModel = new AdminEventGuestCRUDModel($db);
        $this->gettersModel = new AdminEventGuestGettersModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
    }
    public function assignGuest(int $idUsuarioAdmin, array $data): array
    {
        if ($this->isGuestAlreadyAssigned($data['id_persona'], $data['id_evento'])) {
            return [
                'status'  => 'error',
                'message' => 'El invitado ya está asignado a este evento.'
            ];
        }

        $result = $this->eventGuestModel->addGuestToEvent($data);

        if ($result['status'] === 'success') {
            $detalle = "Invitado ID: {$data['id_persona']} asignado al evento ID: {$data['id_evento']}";
            $this->auditModel->log($idUsuarioAdmin, 'CREAR', 'invitados_evento', $detalle);
        }

        return $result;
    }

    public function updateGuestAssignment(int $idUsuarioAdmin, int $id, array $data): array
    {
        if (!$this->assignmentExists($id)) {
            return [
                'status'  => 'error',
                'message' => 'La asignación no existe.'
            ];
        }

        $result = $this->eventGuestModel->updateGuestEvent($id, $data);

        if ($result['status'] === 'success') {
            $detalle = "Asignación ID: {$id} actualizada para invitado ID: {$data['id_persona']} en evento ID: {$data['id_evento']}";
            $this->auditModel->log($idUsuarioAdmin, 'ACTUALIZAR', 'invitados_evento', $detalle);
        }

        return $result;
    }

    public function removeGuestFromEvent(int $idUsuarioAdmin, int $id): array
    {
        if (!$this->assignmentExists($id)) {
            return [
                'status'  => 'error',
                'message' => 'La asignación no existe.'
            ];
        }

        $result = $this->eventGuestModel->deleteGuestEvent($id);

        if ($result['status'] === 'success') {
            $detalle = "Asignación ID: {$id} eliminada correctamente";
            $this->auditModel->log($idUsuarioAdmin, 'ELIMINAR', 'invitados_evento', $detalle);
        }

        return $result;
    }

    private function isGuestAlreadyAssigned(int $idPersona, int $idEvento): bool
    {
        $sql = "SELECT COUNT(*) AS count
                FROM invitados_evento
                WHERE id_persona = :id_persona AND id_evento = :id_evento";

        $stmt = $this->eventGuestModel->query($sql, [
            ':id_persona' => $idPersona,
            ':id_evento'  => $idEvento
        ]);

        return ((int) ($stmt->fetchColumn())) > 0;
    }

    private function assignmentExists(int $id): bool
    {
        $sql = "SELECT COUNT(*) AS count
                FROM invitados_evento
                WHERE id_invitado_evento = :id";

        $stmt = $this->eventGuestModel->query($sql, [':id' => $id]);

        return ((int) ($stmt->fetchColumn())) > 0;
    }

    public function listAllGuests(): array
    {
        return $this->gettersModel->getAllEventGuests();
    }

    public function getGuest(int $id): array
    {
        return $this->gettersModel->getEventGuestById($id);
    }

    public function getGuestsByEventId(int $id_evento): array
    {
        return $this->gettersModel->getGuestsByEventId($id_evento);
    }

    public function getAllGuestStatistics(): array
    {
        return $this->gettersModel->getAllGuestStatistics();
    }

}
