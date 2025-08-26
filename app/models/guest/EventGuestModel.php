<?php

class EventGuestModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getIdInvitadoByUsuario(int $idUsuario): ?int
    {
        $sql = 'SELECT i.id_invitado
                FROM invitados i
                INNER JOIN personas p ON p.id_persona = i.id_persona
                INNER JOIN usuarios u ON u.id_persona = p.id_persona
                WHERE u.id_usuario = :idUsuario
                  AND i.activo = 1
                  AND p.activo = 1
                  AND u.activo = 1
                LIMIT 1';
        $stmt = $this->query($sql, [':idUsuario' => $idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['id_invitado'] : null;
    }

    public function getAllEventsWithRegisteredFlag(int $idInvitado): array
    {
        $sql = 'SELECT e.*,
                       CASE WHEN ie.id_invitado_evento IS NULL THEN 0 ELSE 1 END AS inscrito
                FROM eventos e
                LEFT JOIN invitados_evento ie
                  ON ie.id_evento = e.id_evento AND ie.id_invitado = :idInvitado';
        $stmt = $this->query($sql, [':idInvitado' => $idInvitado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isAlreadyRegistered(int $idInvitado, int $idEvento): bool
    {
        $sql = 'SELECT 1 FROM invitados_evento WHERE id_invitado = ? AND id_evento = ? LIMIT 1';
        $st = $this->getDB()->prepare($sql);
        $st->execute([$idInvitado, $idEvento]);
        return (bool) $st->fetchColumn();
    }

    public function eventExists(int $idEvento): bool
    {
        $st = $this->getDB()->prepare('SELECT 1 FROM eventos WHERE id_evento=?');
        $st->execute([$idEvento]);
        return (bool) $st->fetchColumn();
    }

    public function hasCapacity(int $idEvento): bool
    {
        $sql = 'SELECT 
                  (e.cupo_maximo IS NULL OR e.cupo_maximo = 0) 
                  OR (e.cupo_maximo > (SELECT COUNT(*) FROM invitados_evento WHERE id_evento = e.id_evento))
                FROM eventos e WHERE e.id_evento = ?';
        $st = $this->getDB()->prepare($sql);
        $st->execute([$idEvento]);
        return (bool) $st->fetchColumn();
    }

    public function createRegistration(int $idInvitado, int $idEvento, string $token): array
    {
        try {
            $sql = 'INSERT INTO invitados_evento
                    (id_invitado, id_evento, token, estado_asistencia, fecha_inscripcion, certificado_generado)
                VALUES
                    (:id_invitado, :id_evento, :token, 0, NOW(), 0)';
            $params = [
                ':id_invitado' => $idInvitado,
                ':id_evento' => $idEvento,
                ':token' => $token
            ];
            $this->query($sql, $params);
            return ['status' => 'success', 'last_id' => $this->getDB()->lastInsertId()];
        } catch (PDOException $e) {
            error_log('[createRegistration] SQL ERROR: ' . $e->getMessage());
            return ['status' => 'error', 'db_error' => $e->getMessage()];
        }
    }
}
