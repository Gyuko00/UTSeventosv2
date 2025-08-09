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
    
    public function getEventSpeaker(int $eventoId): array
    {
        try {
            $sql = 'SELECT 
                        pe.id_ponente_evento,
                        pe.id_ponente,
                        pe.id_evento,
                        pe.hora_participacion,
                        pe.estado_asistencia,
                        pe.certificado_generado,
                        pe.fecha_registro,
                        p.nombres as ponente_nombres,
                        p.apellidos as ponente_apellidos,
                        p.correo_personal as ponente_email,
                        p.telefono as ponente_telefono,
                        p.tipo_documento as ponente_tipo_documento,
                        p.numero_documento as ponente_numero_documento,
                        u.usuario as ponente_usuario
                    FROM ponentes_evento pe
                    INNER JOIN usuarios u ON pe.id_ponente = u.id_usuario
                    INNER JOIN personas p ON u.id_persona = p.id_persona
                    WHERE pe.id_evento = :evento_id';
            
            $stmt = $this->query($sql, ['evento_id' => $eventoId]);
            $ponente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$ponente) {
                return ['status' => 'error', 'message' => 'No hay ponente asignado a este evento'];
            }
            
            return ['status' => 'success', 'data' => $ponente];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener ponente del evento: ' . $e->getMessage()
            ];
        }
    }
    
    public function getEventStats(int $eventoId): array
    {
        try {
            $sql = 'SELECT 
                        e.cupo_maximo,
                        COALESCE(COUNT(pe.id_ponente_evento), 0) as ponentes_asignados,
                        COALESCE(SUM(CASE WHEN pe.estado_asistencia = "asistio" THEN 1 ELSE 0 END), 0) as ponentes_asistieron,
                        COALESCE(SUM(CASE WHEN pe.certificado_generado = 1 THEN 1 ELSE 0 END), 0) as certificados_generados
                    FROM eventos e
                    LEFT JOIN ponentes_evento pe ON e.id_evento = pe.id_evento
                    WHERE e.id_evento = :evento_id
                    GROUP BY e.id_evento, e.cupo_maximo';
            
            $stmt = $this->query($sql, ['evento_id' => $eventoId]);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$stats) {
                return ['status' => 'error', 'message' => 'No se pudieron obtener las estadísticas'];
            }
            
            // Calcular porcentajes
            $stats['ocupacion_porcentaje'] = $stats['cupo_maximo'] > 0 ? 
                round(($stats['ponentes_asignados'] / $stats['cupo_maximo']) * 100, 2) : 0;
            
            return ['status' => 'success', 'data' => $stats];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener estadísticas del evento: ' . $e->getMessage()
            ];
        }
    }
    
    public function getEventParticipants(int $eventoId): array
    {
        try {
            $sql = 'SELECT 
                        pe.id_ponente_evento,
                        pe.hora_participacion,
                        pe.estado_asistencia,
                        pe.certificado_generado,
                        pe.fecha_registro,
                        p.nombres,
                        p.apellidos,
                        p.correo_personal,
                        p.telefono,
                        u.usuario
                    FROM ponentes_evento pe
                    INNER JOIN usuarios u ON pe.id_ponente = u.id_usuario
                    INNER JOIN personas p ON u.id_persona = p.id_persona
                    WHERE pe.id_evento = :evento_id
                    ORDER BY pe.fecha_registro DESC';
            
            $stmt = $this->query($sql, ['evento_id' => $eventoId]);
            $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ['status' => 'success', 'data' => $participantes];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener participantes del evento: ' . $e->getMessage()
            ];
        }
    }

    public function findConflictingEvent(string $fecha, string $lugar): ?array
    {
        try {
            $sql = 'SELECT id_evento FROM eventos WHERE fecha = ? AND lugar_detallado = ? LIMIT 1';
            $stmt = $this->getDB()->prepare($sql);
            $stmt->execute([$fecha, $lugar]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    private function hasAssignedGuestsOrSpeakers(int $idEvento): bool
    {
        if ($idEvento <= 0) {
            throw new InvalidArgumentException('ID de evento inválido.');
        }

        $sqlGuests = 'SELECT COUNT(*) AS total FROM invitados_evento WHERE id_evento = :id_evento';
        $stmtGuests = $this->guestEventModel->query($sqlGuests, [':id_evento' => $idEvento]);
        $guestCount = $stmtGuests->fetchColumn();

        if ($guestCount > 0) {
            return true;
        }

        $sqlSpeakers = 'SELECT COUNT(*) AS total FROM ponentes_evento WHERE id_evento = :id_evento';
        $stmtSpeakers = $this->speakerEventModel->query($sqlSpeakers, [':id_evento' => $idEvento]);
        $speakerCount = $stmtSpeakers->fetchColumn();

        return $speakerCount > 0;
    }
}
