<?php

class AssignmentCheckAdminModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }
    
    public function hasAssignedGuestsOrSpeakers(int $idEvento): bool
    {
        if ($idEvento <= 0) {
            throw new InvalidArgumentException('ID de evento inválido.');
        }

        $sqlGuests = 'SELECT COUNT(*) AS total FROM invitados_evento WHERE id_evento = :id_evento';
        $stmtGuests = $this->query($sqlGuests, [':id_evento' => $idEvento]);
        $guestCount = $stmtGuests->fetchColumn();

        if ($guestCount > 0) {
            return true;
        }

        $sqlSpeakers = 'SELECT COUNT(*) AS total FROM ponentes_evento WHERE id_evento = :id_evento';
        $stmtSpeakers = $this->query($sqlSpeakers, [':id_evento' => $idEvento]);
        $speakerCount = $stmtSpeakers->fetchColumn();

        return $speakerCount > 0;
    }
}