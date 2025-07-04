<?php

require_once (__DIR__ . '/../../../core/Model.php');

class EventConsultModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function obtenerMisEventos(int $id_persona): array
    {
        $sql = '
            SELECT e.*, ie.fecha_inscripcion, ie.estado_asistencia, ie.certificado_generado
            FROM invitados_evento ie
            JOIN eventos e ON e.id_evento = ie.id_evento
            WHERE ie.id_persona = :id_persona
            ORDER BY e.fecha DESC
        ';
        $stmt = $this->query($sql, [':id_persona' => $id_persona]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEventosDisponibles(int $id_persona): array
    {
        $sql = '
            SELECT e.*, 
                   (SELECT COUNT(*) FROM invitados_evento ie WHERE ie.id_evento = e.id_evento) AS inscritos
            FROM eventos e
            WHERE NOT EXISTS (
                SELECT 1 FROM invitados_evento ie 
                WHERE ie.id_evento = e.id_evento AND ie.id_persona = :id_persona
            )
            HAVING inscritos < e.cupo_maximo
        ';
        $stmt = $this->query($sql, [':id_persona' => $id_persona]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEventosConEstado(int $id_persona): array
    {
        $sql = '
            SELECT e.*, 
                   (SELECT COUNT(*) FROM invitados_evento ie WHERE ie.id_evento = e.id_evento) AS inscritos,
                   EXISTS (
                       SELECT 1 FROM invitados_evento ie2 
                       WHERE ie2.id_evento = e.id_evento AND ie2.id_persona = :id_persona
                   ) AS inscrito
            FROM eventos e
            ORDER BY e.fecha DESC, e.hora_inicio ASC
        ';
        $stmt = $this->query($sql, [':id_persona' => $id_persona]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
