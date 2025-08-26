<?php

/**
 * AdminController: controlador para gestión de eventos desde el administrador.
 */

use \Dompdf\Dompdf;
use \Dompdf\Options;

class AdminController extends Controller
{
    private AdminUserController $userController;
    private AdminEventController $eventController;
    private AdminEventSpeakerController $eventSpeakerController;
    private AdminEventReportService $eventReportService;
    private AdminGlobalReportService $globalReportService;
    private AdminEventService $eventService;
    private AdminEventReportController $eventReportController;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userController = new AdminUserController($db);
        $this->eventController = new AdminEventController($db);
        $this->eventSpeakerController = new AdminEventSpeakerController($db);
        $this->eventReportService = new AdminEventReportService($db);
        $this->globalReportService = new AdminGlobalReportService($db);
        $this->eventService = new AdminEventService($db);
        $this->eventReportController = new AdminEventReportController($db);
    }

    public function home()
    {
        $this->verificarAccesoConRoles([1]);

        $eventos = $this->eventService->getAllEvents(); 

        $this->view('admin/home', [
            'eventos' => $eventos['data'] ?? []
        ], 'admin');
    }

    public function cerrarSesion()
    {
        session_destroy();
        header('Location: ' . URL_PATH . '/auth/login');
        exit;
    }

    public function listarUsuarios()
    {
        $this->userController->listarUsuarios();
    }

    public function detalleUsuario(int $id)
    {
        $this->userController->detalleUsuario($id);
    }

    public function crearUsuario()
    {
        $this->userController->crearUsuario();
    }

    public function editarUsuario(int $id)
    {
        $this->userController->editarUsuario($id);
    }

    public function activarUsuario(int $id)
    {
        $this->userController->activarUsuario($id);
    }

    public function eliminarUsuario($id = null)
    {
        $this->userController->eliminarUsuario($id);
    }

    public function listarEventos()
    {
        $this->eventController->listarEventos();
    }

    public function detalleEvento(int $id)
    {
        $this->eventController->detalleEvento($id);
    }

    public function crearEvento()
    {
        $this->eventController->crearEvento();
    }

    public function getOccupiedSlots()
    {
        $this->eventController->getOccupiedSlots();
    }

    public function editarEvento(int $id)
    {
        $this->eventController->editarEvento($id);
    }

    public function eliminarEvento(int $id)
    {
        $this->eventController->eliminarEvento($id);
    }
    
    public function listarPonentes()
    {
        $this->eventSpeakerController->listarPonentes();
    }

    public function detallePonenteEvento(int $id)
    {
        $this->eventSpeakerController->detallePonenteEvento($id);
    }

    public function asignarPonente()
    {
        $this->eventSpeakerController->asignarPonente();
    }

    public function editarAsignacionPonente(int $id)
    {
        $this->eventSpeakerController->editarAsignacionPonente($id);
    }

    public function eliminarAsignacionPonente(int $id)
    {
        $this->eventSpeakerController->eliminarAsignacionPonente($id);
    }

    public function reporteEvento(int $idEvento)
    {
        $this->verificarAccesoConRoles([1]);
        $service = new AdminEventReportService($this->db);
        $service->generateEventReport($idEvento);
    }

    public function reporteGlobal()
    {
        $this->verificarAccesoConRoles([1]);
        $service = new AdminGlobalReportService($this->db);
        $service->generateGlobalReport();
    }

    public function report($eventoId = null)
    {
        $this->verificarAccesoConRoles([1]);
        $this->eventReportController->report($eventoId);
    }

    private function sendJsonError(string $message): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        exit;
    }

    public function getPonentesAsignados()
    {
        return $this->speakerService->getPonentesAsignados();
    }
}
