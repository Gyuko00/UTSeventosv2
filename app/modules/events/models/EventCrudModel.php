<?php

require_once (__DIR__ . '/../../../core/Model.php');

class EventCrudModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function listarEventos(): array
    {
        $sql = 'SELECT * FROM eventos ORDER BY fecha DESC, hora_inicio ASC';
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearEvento(array $data): int
    {
        $sql = '
            INSERT INTO eventos (
                titulo_evento, descripcion, fecha, hora_inicio, hora_fin,
                departamento_evento, municipio_evento, institucion_evento,
                lugar_detallado, cupo_maximo, id_usuario_creador
            )
            VALUES (
                :titulo_evento, :descripcion, :fecha, :hora_inicio, :hora_fin,
                :departamento_evento, :municipio_evento, :institucion_evento,
                :lugar_detallado, :cupo_maximo, :id_usuario_creador
            )
        ';
        $this->query($sql, [
            ':titulo_evento' => $data['titulo_evento'],
            ':descripcion' => $data['descripcion'],
            ':fecha' => $data['fecha'],
            ':hora_inicio' => $data['hora_inicio'],
            ':hora_fin' => $data['hora_fin'],
            ':departamento_evento' => $data['departamento_evento'],
            ':municipio_evento' => $data['municipio_evento'],
            ':institucion_evento' => $data['institucion_evento'],
            ':lugar_detallado' => $data['lugar_detallado'],
            ':cupo_maximo' => $data['cupo_maximo'],
            ':id_usuario_creador' => $data['id_usuario_creador']
        ]);
        return $this->db->lastInsertId();
    }

    public function editarEvento(int $id_evento, array $data): int
    {
        $sql = '
            UPDATE eventos
            SET 
                titulo_evento = :titulo_evento,
                descripcion = :descripcion,
                fecha = :fecha,
                hora_inicio = :hora_inicio,
                hora_fin = :hora_fin,
                departamento_evento = :departamento_evento,
                municipio_evento = :municipio_evento,
                institucion_evento = :institucion_evento,
                lugar_detallado = :lugar_detallado,
                cupo_maximo = :cupo_maximo
            WHERE id_evento = :id_evento
        ';
        $stmt = $this->query($sql, [
            ':titulo_evento' => $data['titulo_evento'],
            ':descripcion' => $data['descripcion'],
            ':fecha' => $data['fecha'],
            ':hora_inicio' => $data['hora_inicio'],
            ':hora_fin' => $data['hora_fin'],
            ':departamento_evento' => $data['departamento_evento'],
            ':municipio_evento' => $data['municipio_evento'],
            ':institucion_evento' => $data['institucion_evento'],
            ':lugar_detallado' => $data['lugar_detallado'],
            ':cupo_maximo' => $data['cupo_maximo'],
            ':id_evento' => $id_evento
        ]);
        return $stmt->rowCount();
    }

    public function eliminarEvento(int $id_evento): int
    {
        $sql = 'DELETE FROM eventos WHERE id_evento = :id_evento';
        $stmt = $this->query($sql, [':id_evento' => $id_evento]);
        return $stmt->rowCount();
    }

    public function obtenerEventoPorId(int $id_evento): ?array
    {
        $sql = '
            SELECT id_evento, titulo_evento, descripcion, fecha, hora_inicio, hora_fin,
                   departamento_evento, municipio_evento, institucion_evento,
                   lugar_detallado, cupo_maximo, id_usuario_creador
            FROM eventos
            WHERE id_evento = :id_evento
            LIMIT 1
        ';
        $stmt = $this->query($sql, [':id_evento' => $id_evento]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        return $evento ?: null;
    }
}
