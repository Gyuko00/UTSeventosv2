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

    public function verificarInscripcion(int $id_evento, int $id_usuario): array
    {
        $sql = '
            SELECT 
                ie.id_invitado_evento,
                ie.estado_asistencia,
                ie.fecha_inscripcion,
                ie.certificado_generado,
                ie.token
            FROM invitados_evento ie
            JOIN invitados i ON ie.id_invitado = i.id_invitado
            JOIN personas p ON i.id_persona = p.id_persona
            JOIN usuarios u ON u.id_persona = p.id_persona
            WHERE ie.id_evento = :id_evento AND u.id_usuario = :id_usuario
            LIMIT 1
        ';

        try {
            $stmt = $this->query($sql, [
                ':id_evento' => $id_evento,
                ':id_usuario' => $id_usuario
            ]);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return [
                    'inscrito' => true,
                    'datos_inscripcion' => $resultado
                ];
            } else {
                return [
                    'inscrito' => false,
                    'datos_inscripcion' => null
                ];
            }
        } catch (Exception $e) {
            return [
                'inscrito' => false,
                'datos_inscripcion' => null,
                'error' => $e->getMessage()
            ];
        }
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

    public function cancelarInscripcion(int $id_evento, int $id_usuario): bool
    {
        $sql = '
        DELETE ie FROM invitados_evento ie
        JOIN invitados i ON ie.id_invitado = i.id_invitado
        JOIN personas p ON i.id_persona = p.id_persona
        JOIN usuarios u ON u.id_persona = p.id_persona
        WHERE ie.id_evento = :id_evento AND u.id_usuario = :id_usuario
    ';

        try {
            $stmt = $this->query($sql, [
                ':id_evento' => $id_evento,
                ':id_usuario' => $id_usuario
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }


    public function getInvitacionByUsuarioEvento(int $id_usuario, int $id_evento): ?array
    {
        $sql = '
        SELECT ie.id_invitado_evento, ie.token
        FROM invitados_evento ie
        JOIN invitados i  ON i.id_invitado = ie.id_invitado
        JOIN usuarios u   ON u.id_persona = i.id_persona
        WHERE u.id_usuario = :id_usuario AND ie.id_evento = :id_evento
        LIMIT 1';
        $stmt = $this->query($sql, [':id_usuario' => $id_usuario, ':id_evento' => $id_evento]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function setTokenInvitadoEvento(int $id_invitado_evento, string $token): bool
    {
        $sql = 'UPDATE invitados_evento SET token = :t WHERE id_invitado_evento = :id';
        $stmt = $this->query($sql, [':t' => $token, ':id' => $id_invitado_evento]);
        return $stmt->rowCount() > 0;
    }

    public function getEventById(int $id): array
    {
        try {
            $sql = 'SELECT 
                        e.id_evento,
                        e.titulo_evento,
                        e.tema,
                        e.descripcion,
                        e.fecha,
                        e.hora_inicio,
                        e.hora_fin,
                        e.departamento_evento,
                        e.municipio_evento,
                        e.institucion_evento,
                        e.lugar_detallado,
                        e.cupo_maximo,
                        e.id_usuario_creador,
                        p.nombres as creador_nombres,
                        p.apellidos as creador_apellidos,
                        p.correo_personal as creador_email,
                        p.telefono as creador_telefono
                    FROM eventos e 
                    LEFT JOIN usuarios u ON e.id_usuario_creador = u.id_usuario
                    LEFT JOIN personas p ON u.id_persona = p.id_persona
                    WHERE e.id_evento = :id';

            $stmt = $this->query($sql, ['id' => $id]);
            $evento = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$evento) {
                return ['status' => 'error', 'message' => 'Evento no encontrado'];
            }

            return ['status' => 'success', 'data' => $evento];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener evento: ' . $e->getMessage()
            ];
        }
    }

}
