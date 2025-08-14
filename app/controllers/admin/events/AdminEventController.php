<?php

/**
 * AdminEventController: controlador para gestión de eventos desde el administrador.
 */
class AdminEventController extends Controller
{
    protected crearEventoAdminCrudController $crearEventoController;
    protected editarEventoAdminCrudController $editarEventoController;
    protected eliminarEventoAdminCrudController $eliminarEventoController;
    protected AdminEventService $eventService;
    protected AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crearEventoController = new crearEventoAdminCrudController($db);
        $this->editarEventoController = new editarEventoAdminCrudController($db);
        $this->eliminarEventoController = new eliminarEventoAdminCrudController($db);
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

    public function getOccupiedSlots()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        $fecha = $input['fecha'] ?? '';
        $lugar = $input['lugar'] ?? '';
        $excludeEventId = isset($input['exclude_event_id']) ? (int) $input['exclude_event_id'] : null;

        if (empty($fecha) || empty($lugar)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Fecha y lugar son requeridos'
            ]);
            return;
        }

        try {
            $result = $this->eventService->getOccupiedTimeSlots($fecha, $lugar, $excludeEventId);

            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    public function crearEvento()
    {
        $this->verificarAccesoConRoles([1]);

        $this->crearEventoController->crearEvento();
    }

    public function editarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->editarEventoController->editarEvento($id);
    }

    public function eliminarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->eliminarEventoController->eliminarEvento($id);
    }
}
