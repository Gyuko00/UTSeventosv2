<?php

/**
 * AdminEventController: controlador para gestión de eventos desde el administrador.
 */
class AdminEventController extends Controller
{
    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
    }

    public function listarEventos()
    {
        $this->verificarAccesoConRoles([1]);

        $eventos = $this->eventService->getAllEvents();
        $this->view('admin/listar_eventos', ['eventos' => $eventos['data'] ?? []], 'admin');
    }

    public function detalleEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/listar_eventos');
        }

        $this->view('admin/detalle_evento', ['evento' => $evento['data']], 'admin');
    }

    public function crearEvento()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = $_POST['event'] ?? [];

            $result = $this->eventService->createEvent($eventData);

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Evento creado correctamente';
                $this->redirect('admin/listar_eventos');
            }

            $this->view('admin/crear_evento', ['error' => $result['message']], 'admin');
            return;
        }

        $this->view('admin/crear_evento', [], 'admin');
    }

    public function editarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = $_POST['event'] ?? [];

            $result = $this->eventService->updateEvent($id, $eventData);

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Evento actualizado correctamente';
                $this->redirect('admin/listar_eventos');
            }

            $this->view('admin/editar_evento', ['error' => $result['message']], 'admin');
            return;
        }

        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/listar_eventos');
        }

        $this->view('admin/editar_evento', ['evento' => $evento['data']], 'admin');
    }

    public function eliminarEvento(int $id)
    {
       $this->verificarAccesoConRoles([1]);

        $result = $this->eventService->deleteEvent($id);

        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Evento eliminado correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }

        $this->redirect('admin/listar_eventos');
    }
}
