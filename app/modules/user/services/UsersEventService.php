<?php

require_once (__DIR__ . '/BaseUserService.php');
require_once (__DIR__ . '/../../events/models/EventModel.php');

class UsersEventoService extends BaseUserService
{
    private $eventModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventModel = new EventModel($db);
    }

    public function evento(): array
    {
        $this->iniciarSesionSegura();
        $id_evento = $_GET['id_evento'] ?? null;
        if (!$id_evento) {
            throw new Exception('Evento no encontrado.');
        }
        $data = $this->eventModel->obtenerEventoConPonentes($id_evento);
        if (!$data) {
            throw new Exception('Evento no disponible.');
        }
        return $data;
    }
}
