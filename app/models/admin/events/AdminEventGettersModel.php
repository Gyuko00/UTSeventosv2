<?php

/**
 * AdminEventGettersModel: Getters del CRUD de eventos desde el administrador
 */
class AdminEventGettersModel extends Model
{
    public function __construct(PDO $db)
    {
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

    public function getEventById(int $id)
    {
        $this->validateId($id);

        $sql = 'SELECT * FROM eventos WHERE id_evento = :id';
        $stmt = $this->query($sql, [':id' => $id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            return ['status' => 'error', 'message' => 'Evento no encontrado'];
        }

        return ['status' => 'success', 'data' => $evento];
    }
}
