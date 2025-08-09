<?php

/**
 * AdminEventController: controlador para gestión de eventos desde el administrador.
 */
class AdminEventController extends Controller
{
    private AdminEventService $eventService;
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
        $this->userService = new AdminUserService($db);
    }

    public function listarEventos()
    {
        $this->verificarAccesoConRoles([1]);

        $eventos = $this->eventService->getAllEvents();
        $this->view('admin/eventos', ['eventos' => $eventos['data'] ?? []], 'admin');
    }

    public function detalleEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

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

        $ponente = $this->eventService->getEventSpeaker($id);
        if ($ponente['status'] === 'success') {
            $datos['ponente'] = $ponente['data'];
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

    public function crearEvento()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/crear_evento', [], 'admin');
            return;
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Content-Type: application/json');

        try {
            $input = file_get_contents('php://input');
            if (empty($input)) {
                throw new Exception('Datos no recibidos', 400);
            }

            $data = json_decode($input, true);
            if ($data === null) {
                throw new Exception('JSON inválido', 400);
            }

            $eventData = $data['event'] ?? [];
            $eventData['id_usuario_creador'] = $_SESSION['id_usuario'] ?? null;

            if (empty($eventData['id_usuario_creador'])) {
                throw new Exception('Usuario no autenticado', 401);
            }

            $result = $this->eventService->createEvent($eventData);

            die(json_encode($result));
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            die(json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]));
        }
    }

    public function editarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = $_POST['event'] ?? [];

            $result = $this->eventService->updateEvent($id, $eventData);

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Evento actualizado correctamente';
                $this->redirect('admin/eventos');
            }

            $this->view('admin/editar_evento', ['error' => $result['message']], 'admin');
            return;
        }

        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/eventos');
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

        $this->redirect('admin/eventos');
    }
}
