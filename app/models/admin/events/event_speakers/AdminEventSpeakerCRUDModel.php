<?php
// AdminEventSpeakerCRUDModel - Con métodos para consultas

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
        return $this->eventSpeakerCreateCRUDModel->addSpeakerToEvent($data);
    }

    public function updateSpeakerEvent(int $id, array $data): array
    {
        return $this->eventSpeakerUpdateCRUDModel->updateSpeakerEvent($id, $data);
    }

    public function deleteSpeakerEvent(int $id): array
    {
        return $this->eventSpeakerDeleteCRUDModel->deleteSpeakerEvent($id);
    }

    public function checkSpeakerAssignment(int $idPonente, int $idEvento): bool
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM ponentes_evento
                WHERE id_ponente = :id_ponente AND id_evento = :id_evento';

        $stmt = $this->query($sql, [
            ':id_ponente' => $idPonente,
            ':id_evento' => $idEvento
        ]);

        return ((int) ($stmt->fetchColumn())) > 0;
    }

    public function checkAssignmentExists(int $id): bool
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM ponentes_evento
                WHERE id_ponente_evento = :id';

        $stmt = $this->query($sql, [':id' => $id]);

        return ((int) ($stmt->fetchColumn())) > 0;
    }

    public function getSpeakersForEvent(int $idEvento): array
    {
        $sql = 'SELECT hora_participacion, nombres, apellidos 
                FROM ponentes_evento pe
                INNER JOIN ponentes p ON pe.id_ponente = p.id_ponente
                WHERE pe.id_evento = :id_evento';

        $stmt = $this->query($sql, [':id_evento' => $idEvento]);

        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
}
?>