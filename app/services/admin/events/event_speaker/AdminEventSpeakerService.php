<?php

/**
 * AdminEventSpeakerService: servicio para la gestión de ponentes asignados a eventos, con auditoría
 */
class AdminEventSpeakerService extends Service
{
    private AdminEventSpeakerCRUDModel $crudModel;
    private AdminEventSpeakerGettersModel $gettersModel;
    private AdminAuditLogModel $auditModel;

    public function __construct(PDO $db)
    {
        $this->crudModel = new AdminEventSpeakerCRUDModel($db);
        $this->gettersModel = new AdminEventSpeakerGettersModel($db);
        $this->auditModel = new AdminAuditLogModel($db);
    }

    public function addSpeakerToEvent(int $idUsuarioAdmin, array $data): array
    {
        if (empty($data['id_ponente']) || empty($data['id_evento'])) {
            return [
                'status' => 'error',
                'message' => 'El ID del ponente y del evento son obligatorios.'
            ];
        }

        if ($this->isSpeakerAlreadyAssigned($data['id_ponente'], $data['id_evento'])) {
            return [
                'status' => 'error',
                'message' => 'El ponente ya está asignado a este evento.'
            ];
        }

        $result = $this->crudModel->addSpeakerToEvent($data);

        if ($result['status'] === 'success') {
            $detalle = "Ponente ID: {$data['id_ponente']} asignado al evento ID: {$data['id_evento']}";
            $this->auditModel->log($idUsuarioAdmin, 'CREAR', 'ponentes_evento', $detalle);
        }

        return $result;
    }

    public function updateSpeakerEvent(int $idUsuarioAdmin, int $id, array $data): array
    {
        if (empty($data['id_ponente']) || empty($data['id_evento'])) {
            return [
                'status' => 'error',
                'message' => 'El ID del ponente y del evento son obligatorios.'
            ];
        }

        if (!$this->assignmentExists($id)) {
            return [
                'status' => 'error',
                'message' => 'La asignación no existe.'
            ];
        }

        $result = $this->crudModel->updateSpeakerEvent($id, $data);

        if ($result['status'] === 'success') {
            $detalle = "Registro de ponente_evento ID: {$id} actualizado correctamente";
            $this->auditModel->log($idUsuarioAdmin, 'ACTUALIZAR', 'ponentes_evento', $detalle);
        }

        return $result;
    }

    public function deleteSpeakerEvent(int $idUsuarioAdmin, int $id): array
    {
        if (!$this->assignmentExists($id)) {
            return [
                'status' => 'error',
                'message' => 'La asignación no existe.'
            ];
        }

        $result = $this->crudModel->deleteSpeakerEvent($id);

        if ($result['status'] === 'success') {
            $detalle = "Registro de ponente_evento ID: {$id} eliminado correctamente";
            $this->auditModel->log($idUsuarioAdmin, 'ELIMINAR', 'ponentes_evento', $detalle);
        }

        return $result;
    }


    private function isSpeakerAlreadyAssigned(int $idPonente, int $idEvento): bool 
    {
        return $this->crudModel->checkSpeakerAssignment($idPonente, $idEvento);
    }

    private function assignmentExists(int $id): bool 
    {
        return $this->crudModel->checkAssignmentExists($id);
    }

    public function listAllEventSpeakers(): array
    {
        return $this->gettersModel->getAllEventSpeakers();
    }

    public function getEventSpeaker(int $id): array
    {
        return $this->gettersModel->getEventSpeakerById($id);
    }

    public function getPonentesDelEvento(int $idEvento): array 
    {
        return $this->crudModel->getSpeakersForEvent($idEvento);
    }
}
