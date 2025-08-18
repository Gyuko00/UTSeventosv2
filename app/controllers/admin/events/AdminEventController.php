<?php

/**
 * AdminEventController: controlador para gestión de eventos desde el administrador.
 */
class AdminEventController extends Controller
{
    protected CreateEventAdminController $crearEvento;
    protected EditEventAdminController $editarEvento;
    protected DeleteEventAdminController $eliminarEvento;
    protected EventDetailAdminController $detalleEvento;
    protected CheckOccupiedSlotsAdminController $verificarFranjaOcupada;
    protected AdminEventService $eventService;
    protected AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->crearEvento = new CreateEventAdminController($db);
        $this->editarEvento = new EditEventAdminController($db);
        $this->eliminarEvento = new DeleteEventAdminController($db);

        $this->detalleEvento = new EventDetailAdminController($db);
        $this->verificarFranjaOcupada = new CheckOccupiedSlotsAdminController($db);

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

        return $this->detalleEvento->detalleEvento($id);
    }

    public function getOccupiedSlots()
    {
        $this->verificarAccesoConRoles([1]);

        return $this->verificarFranjaOcupada->getOccupiedSlots();
    }

    public function crearEvento()
    {
        $this->verificarAccesoConRoles([1]);

        $this->crearEvento->crearEvento();
    }

    public function editarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->editarEvento->editarEvento($id);
    }

    public function eliminarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->eliminarEvento->eliminarEvento($id);
    }
}
