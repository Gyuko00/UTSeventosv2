<?php

/**
 * AdminEventSpeakerGettersModel: obtiene datos de ponentes en eventos
 */
class AdminEventSpeakerGettersModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllEventSpeakers(): array 
    {
        $sql = "SELECT 
                    pe.id_ponente_evento,
                    pe.id_ponente,
                    pe.id_evento,
                    pe.hora_participacion,
                    pe.estado_asistencia,
                    pe.certificado_generado,
                    pe.fecha_registro,
                    p.tema,
                    p.institucion_ponente,
                    per.nombres,
                    per.apellidos,
                    per.correo_personal,
                    per.telefono,
                    e.titulo_evento,
                    e.fecha,
                    e.hora_inicio,
                    e.hora_fin
                FROM ponentes_evento pe
                INNER JOIN ponentes p ON pe.id_ponente = p.id_ponente
                INNER JOIN personas per ON p.id_persona = per.id_persona
                INNER JOIN eventos e ON pe.id_evento = e.id_evento
                ORDER BY e.fecha ASC, pe.hora_participacion ASC";
                
        $stmt = $this->query($sql);
    
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
    
    public function getEventSpeakerById(int $id): array 
    {
        $this->validateId($id);
    
        $sql = "SELECT 
                    -- Datos de ponentes_evento
                    pe.id_ponente_evento,
                    pe.id_ponente,
                    pe.id_evento,
                    pe.hora_participacion,
                    pe.estado_asistencia,
                    pe.certificado_generado,
                    pe.fecha_registro,
                    
                    -- Datos del ponente
                    p.tema,
                    p.institucion_ponente,
                    p.especializacion,
                    
                    -- Datos de la persona
                    per.nombres,
                    per.apellidos,
                    per.correo_personal,
                    per.telefono,
                    per.numero_documento,
                    per.tipo_documento,
                    
                    -- Datos completos del evento
                    e.titulo_evento,
                    e.descripcion,
                    e.fecha,
                    e.hora_inicio,
                    e.hora_fin,
                    e.departamento_evento,
                    e.municipio_evento,
                    e.institucion_evento,
                    e.lugar_detallado,
                    e.cupo_maximo,
                    e.tema as tema_evento,
                    
                    -- Datos del creador del evento
                    u.usuario as creador_usuario,
                    per_creador.nombres as creador_nombres,
                    per_creador.apellidos as creador_apellidos
                    
                FROM ponentes_evento pe
                INNER JOIN ponentes p ON pe.id_ponente = p.id_ponente
                INNER JOIN personas per ON p.id_persona = per.id_persona
                INNER JOIN eventos e ON pe.id_evento = e.id_evento
                INNER JOIN usuarios u ON e.id_usuario_creador = u.id_usuario
                INNER JOIN personas per_creador ON u.id_persona = per_creador.id_persona
                WHERE pe.id_ponente_evento = :id";
                
        $stmt = $this->query($sql, [':id' => $id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$record) {
            return ['status' => 'error', 'message' => 'Registro no encontrado.'];
        }
    
        return ['status' => 'success', 'data' => $record];
    }
}
