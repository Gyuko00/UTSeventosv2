<?php

/**
 * AdminEventGuestGettersModel: obtiene datos de invitados en eventos
 */
class AdminEventGuestGettersModel extends Model {

    public function getAllEventGuests(): array {
        $sql = "SELECT ie.*, p.nombres, p.apellidos, e.titulo_evento, e.fecha
                FROM invitados_evento ie
                INNER JOIN personas p ON ie.id_persona = p.id_persona
                INNER JOIN eventos e ON ie.id_evento = e.id_evento";
        $stmt = $this->query($sql);

        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getEventGuestById(int $id): array {
        $this->validateId($id);

        $sql = "SELECT ie.*, p.nombres, p.apellidos, e.titulo_evento, e.fecha
                FROM invitados_evento ie
                INNER JOIN personas p ON ie.id_persona = p.id_persona
                INNER JOIN eventos e ON ie.id_evento = e.id_evento
                WHERE ie.id_invitado_evento = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            return ['status' => 'error', 'message' => 'Registro no encontrado.'];
        }

        return ['status' => 'success', 'data' => $record];
    }

    public function getGuestsByEventId(int $id_evento): array {
        $this->validateId($id_evento);
    
        $sql = "SELECT 
                    ie.id_persona,
                    ie.id_evento,
                    ie.estado_asistencia,
                    ie.fecha_inscripcion,
                    
                    i.tipo_invitado,
                    i.correo_institucional,
                    i.programa_academico,
                    i.nombre_carrera,
                    i.jornada,
                    i.facultad,
                    i.cargo,
                    i.sede_institucion,
                    
                    e.titulo_evento,
                    e.tema,
                    e.fecha,
                    e.hora_inicio,
                    e.institucion_evento
                    
                FROM invitados_evento ie
                INNER JOIN invitados i ON ie.id_persona = i.id_persona
                INNER JOIN eventos e ON ie.id_evento = e.id_evento
                WHERE ie.id_evento = :id_evento";
    
        $stmt = $this->query($sql, [':id_evento' => $id_evento]);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$records) {
            return ['status' => 'error', 'message' => 'No hay invitados para este evento.'];
        }
    
        return ['status' => 'success', 'data' => $records];
    }
    
}
