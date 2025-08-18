<?php

class CreateEventAdminController extends Controller {

    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
    }

    public function crearEvento()
    {

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
}