<?php

class EventQueryAdminModel extends Model{
    
    public function __construct(PDO $db) {
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

}