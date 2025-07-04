<?php

require_once (__DIR__ . '/../../../core/Model.php');

class EventSpeakerModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function agregarPonenteAEvento(int $id_evento, int $id_ponente, string $hora_participacion): bool
    {
        $sql = '
            INSERT INTO ponentes_evento (id_evento, id_ponente, hora_participacion)
            VALUES (:id_evento, :id_ponente, :hora_participacion)
        ';
        $stmt = $this->query($sql, [
            ':id_evento' => $id_evento,
            ':id_ponente' => $id_ponente,
            ':hora_participacion' => $hora_participacion
        ]);

        return $stmt->rowCount() > 0;
    }

    public function eliminarPonenteDeEvento(int $id_evento, int $id_ponente): bool
    {
        $sql = '
            DELETE FROM ponentes_evento
            WHERE id_evento = :id_evento AND id_ponente = :id_ponente
        ';
        $stmt = $this->query($sql, [
            ':id_evento' => $id_evento,
            ':id_ponente' => $id_ponente
        ]);

        return $stmt->rowCount() > 0;
    }

    public function obtenerPonentesPorEvento(int $id_evento): array
    {
        $sql = '
            SELECT p.id_ponente, p.tema, p.descripcion_biografica, p.especializacion, p.institucion_ponente,
                   per.nombres, per.apellidos, pe.hora_participacion
            FROM ponentes_evento pe
            JOIN ponentes p ON pe.id_ponente = p.id_ponente
            JOIN personas per ON p.id_persona = per.id_persona
            WHERE pe.id_evento = :id_evento
        ';
        $stmt = $this->query($sql, [':id_evento' => $id_evento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEventoConPonentes(int $id_evento): ?array
    {
        $sqlEvento = 'SELECT * FROM eventos WHERE id_evento = :id_evento';
        $stmtEvento = $this->query($sqlEvento, [':id_evento' => $id_evento]);
        $evento = $stmtEvento->fetch(PDO::FETCH_ASSOC);
        if (!$evento) {
            return null;
        }
        $ponentes = $this->obtenerPonentesPorEvento($id_evento);
        return [
            'evento' => $evento,
            'ponentes' => $ponentes
        ];
    }
}
