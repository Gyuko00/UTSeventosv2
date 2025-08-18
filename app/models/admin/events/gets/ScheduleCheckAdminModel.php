<?php

class ScheduleCheckAdminModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getOccupiedTimeSlots(string $fecha, string $lugar, int $excludeEventId = null): array
    {
        try {
            $sql = 'SELECT hora_inicio, hora_fin, titulo_evento, id_evento
                FROM eventos 
                WHERE fecha = :fecha 
                AND lugar_detallado = :lugar';

            $params = [
                'fecha' => $fecha,
                'lugar' => $lugar
            ];

            if ($excludeEventId !== null) {
                $sql .= ' AND id_evento != :exclude_id';
                $params['exclude_id'] = $excludeEventId;
            }

            $sql .= ' ORDER BY hora_inicio ASC';

            $stmt = $this->query($sql, $params);
            $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 'success', 'data' => $eventos];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener horarios ocupados: ' . $e->getMessage()
            ];
        }
    }

    public function findTimeConflictingEvent(string $fecha, string $lugar, string $horaInicio, string $horaFin, int $excludeId = null): ?array
    {
        try {
            if ($excludeId !== null) {
                $sql = 'SELECT id_evento, titulo_evento, hora_inicio, hora_fin 
                        FROM eventos 
                        WHERE fecha = ? 
                        AND lugar_detallado = ? 
                        AND id_evento != ?
                        AND (
                            (? <= hora_inicio AND ? >= hora_fin) OR
                            (? >= hora_inicio AND ? <= hora_fin) OR
                            (? < hora_inicio AND ? > hora_inicio AND ? <= hora_fin) OR
                            (? >= hora_inicio AND ? < hora_fin AND ? > hora_fin) OR
                            (? = hora_inicio AND ? = hora_fin)
                        )';
                $stmt = $this->getDB()->prepare($sql);
                $stmt->execute([
                    $fecha, $lugar, $excludeId,
                    $horaInicio, $horaFin,
                    $horaInicio, $horaFin,
                    $horaInicio, $horaFin, $horaFin,
                    $horaInicio, $horaInicio, $horaFin,
                    $horaInicio, $horaFin
                ]);
            } else {
                $sql = 'SELECT id_evento, titulo_evento, hora_inicio, hora_fin 
                        FROM eventos 
                        WHERE fecha = ? 
                        AND lugar_detallado = ?
                        AND (
                            (? <= hora_inicio AND ? >= hora_fin) OR
                            (? >= hora_inicio AND ? <= hora_fin) OR
                            (? < hora_inicio AND ? > hora_inicio AND ? <= hora_fin) OR
                            (? >= hora_inicio AND ? < hora_fin AND ? > hora_fin) OR
                            (? = hora_inicio AND ? = hora_fin)
                        )';
                $stmt = $this->getDB()->prepare($sql);
                $stmt->execute([
                    $fecha, $lugar,
                    $horaInicio, $horaFin,
                    $horaInicio, $horaFin,
                    $horaInicio, $horaFin, $horaFin,
                    $horaInicio, $horaInicio, $horaFin,
                    $horaInicio, $horaFin
                ]);
            }

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : null;
        } catch (PDOException $e) {
            return null;
        }
    }
}
