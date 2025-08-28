<?php

class EventDetailsAdminModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    // app/models/admin/EventModel.php (o donde tengas el modelo del admin)
    public function getEventSpeakers(int $id_evento): array
    {
        $sql = '
        SELECT 
            pe.id_ponente_evento,
            pe.id_evento,
            pe.hora_participacion,
            pe.estado_asistencia,
            pe.certificado_generado,
            pe.fecha_registro,

            p.id_ponente,
            p.activo               AS ponente_activo,
            p.tema                 AS ponente_tema,
            p.descripcion_biografica,
            p.especializacion,
            p.institucion_ponente,

            per.id_persona,
            per.nombres            AS ponente_nombres,
            per.apellidos          AS ponente_apellidos,
            per.tipo_documento     AS ponente_tipo_documento,
            per.numero_documento   AS ponente_numero_documento,
            per.correo_personal    AS ponente_email,
            per.telefono           AS ponente_telefono
        FROM ponentes_evento pe
        JOIN ponentes p        ON p.id_ponente   = pe.id_ponente
        JOIN personas per      ON per.id_persona = p.id_persona
        WHERE pe.id_evento = :id_evento
        ORDER BY 
            pe.hora_participacion IS NULL, 
            pe.hora_participacion ASC,
            per.nombres ASC, per.apellidos ASC
    ';
        try {
            $stmt = $this->query($sql, [':id_evento' => $id_evento]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 'success', 'data' => $rows];
        } catch (Exception $e) {
            error_log('getEventSpeakers error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'No fue posible cargar los ponentes'];
        }
    }

    public function getEventSpeaker(int $id_evento): array
    {
        $all = $this->getEventSpeakers($id_evento);
        if (($all['status'] ?? '') === 'success' && !empty($all['data'])) {
            return ['status' => 'success', 'data' => $all['data'][0]];
        }
        return ['status' => 'error', 'message' => 'Sin ponentes asignados'];
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

            $stats['ocupacion_porcentaje'] = $stats['cupo_maximo'] > 0
                ? round(($stats['ponentes_asignados'] / $stats['cupo_maximo']) * 100, 2)
                : 0;

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

    public function getEventInvitees(int $eventoId): array
    {
        try {
            $sql = 'SELECT 
                    ie.id_invitado_evento,
                    ie.estado_asistencia,
                    ie.fecha_inscripcion,
                    ie.certificado_generado,
                    p.nombres,
                    p.apellidos,
                    p.numero_documento as documento,
                    p.correo_personal as email,
                    p.telefono,
                    i.tipo_invitado,
                    i.correo_institucional,
                    i.programa_academico,
                    i.nombre_carrera as carrera,
                    i.jornada,
                    i.facultad,
                    i.cargo,
                    i.sede_institucion,
                    u.usuario,
                    e.titulo_evento as evento,
                    e.fecha as fecha,
                    e.hora_inicio as hora_inicio,
                    e.hora_fin as hora_fin
                FROM invitados_evento ie
                INNER JOIN usuarios u ON ie.id_invitado = u.id_usuario
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN invitados i ON u.id_usuario = i.id_invitado
                INNER JOIN eventos e ON ie.id_evento = e.id_evento
                WHERE ie.id_evento = :evento_id
                ORDER BY p.apellidos, p.nombres';

            $stmt = $this->query($sql, ['evento_id' => $eventoId]);

            $invitados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 'success', 'data' => $invitados];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener invitados del evento: ' . $e->getMessage()
            ];
        }
    }

    public function getEventInviteesStats(int $eventoId): array
    {
        try {
            $invitadosResult = $this->getEventInvitees($eventoId);

            if ($invitadosResult['status'] !== 'success') {
                return $invitadosResult;
            }

            $invitados = $invitadosResult['data'];
            $totalInvitados = count($invitados);

            if ($totalInvitados === 0) {
                return [
                    'status' => 'success',
                    'data' => [
                        'total_invitados' => 0,
                        'stats_carreras' => [],
                        'stats_programas' => [],
                        'stats_facultades' => [],
                        'stats_jornadas' => [],
                        'stats_asistencia' => [],
                        'top_carrera' => null,
                        'top_programa' => null,
                        'top_facultad' => null
                    ]
                ];
            }

            $carreras = [];
            $programas = [];
            $facultades = [];
            $jornadas = [];
            $asistencia = ['asistio' => 0, 'no_asistio' => 0, 'pendiente' => 0];

            foreach ($invitados as $inv) {
                $carrera = $inv['carrera'] ?? 'No especificado';
                $carreras[$carrera] = ($carreras[$carrera] ?? 0) + 1;

                $programa = $inv['programa_academico'] ?? 'No especificado';
                $programas[$programa] = ($programas[$programa] ?? 0) + 1;

                $facultad = $inv['facultad'] ?? 'No especificado';
                $facultades[$facultad] = ($facultades[$facultad] ?? 0) + 1;

                $jornada = $inv['jornada'] ?? 'No especificado';
                $jornadas[$jornada] = ($jornadas[$jornada] ?? 0) + 1;

                $estadoAsistencia = $inv['estado_asistencia'] ?? 'pendiente';
                $asistencia[$estadoAsistencia] = ($asistencia[$estadoAsistencia] ?? 0) + 1;
            }

            $topCarrera = !empty($carreras) ? array_keys($carreras, max($carreras)) : [];
            $topPrograma = !empty($programas) ? array_keys($programas, max($programas)) : [];
            $topFacultad = !empty($facultades) ? array_keys($facultades, max($facultades)) : [];

            return [
                'status' => 'success',
                'data' => [
                    'total_invitados' => $totalInvitados,
                    'stats_carreras' => $carreras,
                    'stats_programas' => $programas,
                    'stats_facultades' => $facultades,
                    'stats_jornadas' => $jornadas,
                    'stats_asistencia' => $asistencia,
                    'top_carrera' => [
                        'nombres' => $topCarrera,
                        'cantidad' => !empty($carreras) ? max($carreras) : 0
                    ],
                    'top_programa' => [
                        'nombres' => $topPrograma,
                        'cantidad' => !empty($programas) ? max($programas) : 0
                    ],
                    'top_facultad' => [
                        'nombres' => $topFacultad,
                        'cantidad' => !empty($facultades) ? max($facultades) : 0
                    ]
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener estadísticas de invitados: ' . $e->getMessage()
            ];
        }
    }
}
