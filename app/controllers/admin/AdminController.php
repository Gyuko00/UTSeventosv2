<?php

/**
 * AdminController: controlador para gestión de eventos desde el administrador.
 */
class AdminController extends Controller
{
    private AdminUserController $userController;
    private AdminEventController $eventController;
    private AdminEventGuestController $eventGuestController;
    private AdminEventSpeakerController $eventSpeakerController;
    private AdminEventReportService $eventReportService;
    private AdminGlobalReportService $globalReportService;


    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userController = new AdminUserController($db);
        $this->eventController = new AdminEventController($db);
        $this->eventGuestController = new AdminEventGuestController($db);
        $this->eventSpeakerController = new AdminEventSpeakerController($db);
        $this->eventReportService = new AdminEventReportService($db);
        $this->globalReportService = new AdminGlobalReportService($db);
    }

    public function home()
    {
        $this->verificarAccesoConRoles([1]);

        // En este punto, puedes si quieres preparar algún dato inicial para el calendario JS.
        $data = [];

        $this->view('admin/home', $data, 'admin');
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

    public function eliminarUsuario(int $id)
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

    public function editarEvento(int $id)
    {
        $this->eventController->editarEvento($id);
    }

    public function eliminarEvento(int $id)
    {
        $this->eventController->eliminarEvento($id);
    }

    public function listarInvitados()
    {
        $this->eventGuestController->listarInvitados();
    }

    public function detalleInvitado(int $id)
    {
        $this->eventGuestController->detalleInvitado($id);
    }

    public function asignarInvitado()
    {
        $this->eventGuestController->asignarInvitado();
    }

    public function editarAsignacionInvitado(int $id)
    {
        $this->eventGuestController->editarAsignacionInvitado($id);
    }

    public function eliminarAsignacionInvitado(int $id)
    {
        $this->eventGuestController->eliminarAsignacionInvitado($id);
    }

    public function listarPonentes()
    {
        $this->eventSpeakerController->listarPonentes();
    }

    public function detallePonente(int $id)
    {
        $this->eventSpeakerController->detallePonente($id);
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
}
