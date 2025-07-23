<?php

/**
 * AdminEventGettersModel: Getters del CRUD de eventos desde el administrador
 */
class AdminEventGettersModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getAllEvents()
    {
        $sql = 'SELECT * FROM eventos';
        $stmt = $this->query($sql);
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getEventById(int $id)
    {
        $this->validateId($id);

        $sql = 'SELECT * FROM eventos WHERE id_evento = :id';
        $stmt = $this->query($sql, [':id' => $id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            return ['status' => 'error', 'message' => 'Evento no encontrado'];
        }

        return ['status' => 'success', 'data' => $evento];
    }

    public function findConflictingEvent(string $fecha, string $lugar, ?int $excludeId = null): ?array
    {
        $sql = 'SELECT * FROM eventos WHERE fecha = :fecha AND lugar_detallado = :lugar';
        $params = [
            ':fecha' => $fecha,
            ':lugar' => $lugar
        ];
    
        if ($excludeId !== null) {
            $sql .= ' AND id_evento != :excludeId';
            $params[':excludeId'] = $excludeId;
        }
    
        $stmt = $this->query($sql, $params);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $evento ?: null;
    }

    private function hasAssignedGuestsOrSpeakers(int $idEvento): bool
    {
        if ($idEvento <= 0) {
            throw new InvalidArgumentException("ID de evento inválido.");
        }

        $sqlGuests = "SELECT COUNT(*) AS total FROM invitados_evento WHERE id_evento = :id_evento";
        $stmtGuests = $this->guestEventModel->query($sqlGuests, [':id_evento' => $idEvento]);
        $guestCount = $stmtGuests->fetchColumn();
    
        if ($guestCount > 0) {
            return true;
        }

        $sqlSpeakers = "SELECT COUNT(*) AS total FROM ponentes_evento WHERE id_evento = :id_evento";
        $stmtSpeakers = $this->speakerEventModel->query($sqlSpeakers, [':id_evento' => $idEvento]);
        $speakerCount = $stmtSpeakers->fetchColumn();
    
        return $speakerCount > 0;
    } 
    
}
