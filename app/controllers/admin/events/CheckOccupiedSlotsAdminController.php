<?php

class CheckOccupiedSlotsAdminController extends Controller
{
    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
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

}