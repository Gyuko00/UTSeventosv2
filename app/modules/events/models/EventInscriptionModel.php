<?php

require_once (__DIR__ . '/../../../core/Model.php');

class EventInscriptionModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function inscribirAEvento(int $id_persona, int $id_evento, string $tipo_invitado = 'invitado'): void
    {
        $sql = "
            INSERT INTO invitados_evento (
                id_evento, id_persona, tipo_invitado, fecha_inscripcion, estado_asistencia, certificado_generado
            ) VALUES (
                :id_evento, :id_persona, :tipo_invitado, NOW(), 'no', 0
            )
        ";
        $this->query($sql, [
            ':id_evento' => $id_evento,
            ':id_persona' => $id_persona,
            ':tipo_invitado' => $tipo_invitado
        ]);
    }

    public function cancelarInscripcion(int $id_persona, int $id_evento): bool
    {
        $sql = '
            DELETE FROM invitados_evento 
            WHERE id_persona = :id_persona AND id_evento = :id_evento
        ';
        $stmt = $this->query($sql, [
            ':id_persona' => $id_persona,
            ':id_evento' => $id_evento
        ]);
        return $stmt->rowCount() > 0;
    }

    public function contarInscritos(int $id_evento): int
    {
        $sql = 'SELECT COUNT(*) FROM invitados_evento WHERE id_evento = :id_evento';
        $stmt = $this->query($sql, [':id_evento' => $id_evento]);
        return (int) $stmt->fetchColumn();
    }

    public function yaInscrito(int $id_evento, int $id_persona): bool
    {
        $sql = '
            SELECT COUNT(*) 
            FROM invitados_evento
            WHERE id_evento = :id_evento AND id_persona = :id_persona
        ';
        $stmt = $this->query($sql, [
            ':id_evento' => $id_evento,
            ':id_persona' => $id_persona
        ]);
        return $stmt->fetchColumn() > 0;
    }

}
