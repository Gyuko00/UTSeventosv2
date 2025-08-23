<?php

/**
 * AdminEventSpeakerController: controlador para gestionar ponentes asignados a eventos desde el administrador.
 */
class AdminEventSpeakerController extends Controller
{
    private AdminUserService $userService;
    private AdminEventService $eventService;
    private AdminEventSpeakerService $speakerService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
        $this->eventService = new AdminEventService($db);
        $this->eventSpeakerService = new AdminEventSpeakerService($db);
    }

    public function listarPonentes()
    {
        $this->verificarAccesoConRoles([1]);

        $ponentes = $this->eventSpeakerService->listAllEventSpeakers();
        $this->view('admin/ponentes_evento', ['ponentes' => $ponentes['data'] ?? []], 'admin');
    }

    public function detallePonenteEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $ponente = $this->eventSpeakerService->getEventSpeaker($id);
        if ($ponente['status'] !== 'success') {
            $_SESSION['error_message'] = $ponente['message'];
            $this->redirect('/admin/listarPonentes');
        }

        $this->view('admin/detalle_ponente', ['ponente' => $ponente['data']], 'admin');
    }

    public function asignarPonente()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['speaker_event'] ?? [];

            $result = $this->eventSpeakerService->addSpeakerToEvent(
                $_SESSION['id_usuario'],
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Ponente asignado correctamente al evento';
                $this->redirect('/admin/listarPonentes');
            }

            $eventos = $this->eventService->getAllEvents();
            $ponentes = $this->userService->getAllSpeakers();

            $this->view('admin/asignar_ponente', [
                'error' => $result['message'],
                'eventos' => $eventos['data'] ?? [],
                'ponentes' => $ponentes['data'] ?? []
            ], 'admin');
            return;
        }

        $eventos = $this->eventService->getAllEvents();
        $ponentes = $this->userService->getAllSpeakers();

        $this->view('admin/asignar_ponente', [
            'eventos' => $eventos['data'] ?? [],
            'ponentes' => $ponentes['data'] ?? []
        ], 'admin');
    }

    public function editarAsignacionPonente(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['speaker_event'] ?? [];

            $result = $this->eventSpeakerService->updateSpeakerEvent(
                $_SESSION['id_usuario'],
                $id,
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Asignación actualizada correctamente';
                $this->redirect('/admin/listarPonentes');
            }

            $this->view('admin/editar_asignacion_ponente', ['error' => $result['message']], 'admin');
            return;
        }

        $ponente = $this->eventSpeakerService->getEventSpeaker($id);
        if ($ponente['status'] !== 'success') {
            $_SESSION['error_message'] = $ponente['message'];
            $this->redirect('/admin/listarPonentes');
        }

        $this->view('admin/editar_asignacion_ponente', ['ponente' => $ponente['data']], 'admin');
    }

    // app/controllers/admin/event_speaker/AdminEventSpeakerController.php

    public function eliminarAsignacionPonente(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        // Detectar si es una llamada AJAX
        $isAjax = (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        );

        $result = $this->eventSpeakerService->deleteSpeakerEvent($_SESSION['id_usuario'], $id);

        if ($isAjax) {
            // Responder JSON para fetch()
            // Evita cualquier salida previa
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            header('Content-Type: application/json; charset=utf-8');

            // Usa un código HTTP acorde
            if (($result['status'] ?? '') === 'success') {
                http_response_code(200);
            } else {
                http_response_code(400);
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;  // ¡No continuar al redirect!
        }

        // Flujo normal (no-AJAX): flash + redirect
        if (($result['status'] ?? '') === 'success') {
            $_SESSION['success_message'] = 'Asignación eliminada correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'] ?? 'Error al eliminar';
        }

        $this->redirect('/admin/listarPonentes');
    }

    public function getPonentesAsignados()
    {
        $this->verificarAccesoConRoles([1]);

        $input = json_decode(file_get_contents('php://input'), true);
        $idEvento = $input['id_evento'] ?? null;

        if (!$idEvento) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'ID evento requerido']);
            exit;
        }

        $ponentes = $this->eventSpeakerService->getPonentesDelEvento($idEvento);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'ponentes' => $ponentes['data'] ?? []
        ]);
        exit;
    }
}
