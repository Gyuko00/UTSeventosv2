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
    
        while (ob_get_level() > 0) { ob_end_clean(); }
        header('Content-Type: application/json; charset=utf-8');
    
        try {
            $eventData = null;
    
            $raw = file_get_contents('php://input');
            if (is_string($raw) && strlen(trim($raw)) > 0) {
                $json = json_decode($raw, true);
                if (is_array($json) && isset($json['event']) && is_array($json['event'])) {
                    $eventData = $json['event'];
                }
            }
    
            if ($eventData === null && isset($_POST['event']) && is_array($_POST['event'])) {
                $eventData = $_POST['event'];
            }

    
            $eventData['id_usuario_creador'] = $_SESSION['id_usuario'] ?? null;
            if (empty($eventData['id_usuario_creador'])) {
                http_response_code(401);
                echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
                exit;
            }
    
            $eventData += [
                'titulo_evento' => $eventData['titulo_evento'] ?? '',
                'tema' => $eventData['tema'] ?? '',
                'descripcion' => $eventData['descripcion'] ?? '',
                'fecha' => $eventData['fecha'] ?? '',
                'hora_inicio' => $eventData['hora_inicio'] ?? '',
                'hora_fin' => $eventData['hora_fin'] ?? '',
                'departamento_evento' => $eventData['departamento_evento'] ?? '',
                'municipio_evento' => $eventData['municipio_evento'] ?? '',
                'institucion_evento' => $eventData['institucion_evento'] ?? '',
                'lugar_detallado' => $eventData['lugar_detallado'] ?? '',
                'cupo_maximo' => $eventData['cupo_maximo'] ?? 0,
            ];
    
            $result = $this->eventService->createEvent($eventData);
    
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
    
    
}