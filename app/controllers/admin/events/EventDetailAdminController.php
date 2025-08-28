<?php

class EventDetailAdminController extends Controller
{
    private AdminEventService $eventService;
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
        $this->userService = new AdminUserService($db);
    }

    // app/controllers/admin/AdminController.php
    public function detalleEvento(int $id)
    {
        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/listarEventos');
        }

        $datos = $evento['data'];

        $creador = $this->userService->getUserById($datos['id_usuario_creador']);
        if ($creador['status'] === 'success') {
            $datos['creador'] = $creador['data'];
        }

        $ponentes = $this->eventService->getEventSpeakers($id);
        if ($ponentes['status'] === 'success') {
            $datos['ponentes'] = $ponentes['data'];  
        } else {
            $datos['ponentes'] = [];  
        }

        $estadisticas = $this->eventService->getEventStats($id);
        if ($estadisticas['status'] === 'success') {
            $datos['estadisticas'] = $estadisticas['data'];
        }

        $participantes = $this->eventService->getEventParticipants($id);
        if ($participantes['status'] === 'success') {
            $datos['participantes'] = $participantes['data'];
        }

        $this->view('admin/detalle_evento', ['evento' => $datos], 'admin');
    }
}
