<?php

class ControlEventDetailController extends Controller
{
    private AdminEventService $eventService;
    private AdminUserService $userService;
    private EventGuestService $guestService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
        $this->userService = new AdminUserService($db);
        $this->guestService = new EventGuestService($db);
    }

    public function detalleEvento(int $id)
    {
        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('control/home');
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

        $inscripcion = ['inscrito' => false, 'datos_inscripcion' => null];

        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = (int) $_SESSION['id_usuario'];

            $verificacion = $this->guestService->verificarInscripcionUsuario($id, $id_usuario);
            if ($verificacion['status'] === 'success') {
                $inscripcion = $verificacion['data'];
            }
        }

        $this->view('control/detalle_evento', [
            'evento' => $datos,
            'inscripcion' => $inscripcion,
            'usuario_logueado' => $_SESSION['id_usuario'] ?? null
        ], 'control');
    }
}
