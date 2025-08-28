<?php

class EventControlModel extends Model {

    public function __construct(PDO $db){
        parent::__construct($db);
    }

    public function getAllEvents()
    {
        $sql = 'SELECT * FROM eventos ORDER BY fecha ASC, hora_inicio ASC';
        $stmt = $this->query($sql);
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = (int) $_SESSION['id_usuario'];

            foreach ($eventos as &$evento) {
                $inscripcionSql = '
                SELECT COUNT(*) as inscrito
                FROM invitados_evento ie
                JOIN invitados i ON ie.id_invitado = i.id_invitado
                JOIN personas p ON i.id_persona = p.id_persona
                JOIN usuarios u ON u.id_persona = p.id_persona
                WHERE ie.id_evento = :id_evento AND u.id_usuario = :id_usuario
            ';

                $stmt = $this->query($inscripcionSql, [
                    ':id_evento' => $evento['id_evento'],
                    ':id_usuario' => $id_usuario
                ]);

                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $evento['inscrito'] = (bool) ($resultado['inscrito'] > 0);
            }
        } else {
            foreach ($eventos as &$evento) {
                $evento['inscrito'] = false;
            }
        }

        return [
            'status' => 'success',
            'data' => $eventos
        ];
    }

    public function findByToken(string $token): ?array {
        $sql = '
            SELECT 
                ie.id_invitado_evento,
                ie.id_evento,
                ie.id_invitado,
                ie.estado_asistencia,
                ie.token,
                e.titulo_evento,
                e.fecha,
                e.hora_inicio,
                e.hora_fin,
                p.nombres,
                p.apellidos
            FROM invitados_evento ie
            JOIN eventos   e ON e.id_evento   = ie.id_evento
            JOIN invitados i ON i.id_invitado = ie.id_invitado
            JOIN personas  p ON p.id_persona  = i.id_persona
            WHERE ie.token = :t
            LIMIT 1';
        $st = $this->query($sql, [':t' => $token]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function markAttendanceAndInvalidate(int $id_invitado_evento, string $token, bool $invalidateToken = true): bool {
        $sql = '
            UPDATE invitados_evento
               SET estado_asistencia = 1' . ($invalidateToken ? ', token = NULL' : '') . '
             WHERE id_invitado_evento = :id
               AND token = :t
               AND (estado_asistencia IS NULL OR estado_asistencia <> 1)
             LIMIT 1';
        $st = $this->query($sql, [':id' => $id_invitado_evento, ':t' => $token]);
        return $st->rowCount() === 1;
    }

}