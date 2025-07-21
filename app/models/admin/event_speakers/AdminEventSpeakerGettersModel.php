<?php

/**
 * AdminEventSpeakerGettersModel: obtiene datos de ponentes en eventos
 */
class AdminEventSpeakerGettersModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllEventSpeakers(): array {
        $sql = "SELECT pe.*, p.tema, p.institucion_ponente, e.titulo_evento, e.fecha
                FROM ponentes_evento pe
                INNER JOIN ponentes p ON pe.id_ponente = p.id_ponente
                INNER JOIN eventos e ON pe.id_evento = e.id_evento";
        $stmt = $this->query($sql);

        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getEventSpeakerById(int $id): array {
        $this->validateId($id);

        $sql = "SELECT pe.*, p.tema, p.institucion_ponente, e.titulo_evento, e.fecha
                FROM ponentes_evento pe
                INNER JOIN ponentes p ON pe.id_ponente = p.id_ponente
                INNER JOIN eventos e ON pe.id_evento = e.id_evento
                WHERE pe.id_ponente_evento = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            return ['status' => 'error', 'message' => 'Registro no encontrado.'];
        }

        return ['status' => 'success', 'data' => $record];
    }
}
