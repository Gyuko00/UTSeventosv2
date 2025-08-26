<?php

class UserInscriptionController extends Controller
{

    private EventGuestService $guestEventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->guestEventService = new EventGuestService($db);
    }

    public function inscribirme($id_evento)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode([
                'status'  => 'error',
                'message' => 'Método no permitido. Usa POST.',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    
        try {
            if (!isset($_SESSION['id_usuario'])) {
                http_response_code(401);
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Usuario no autenticado.',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
    
            if (!isset($_SESSION['id_rol'])) {
                http_response_code(403);
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Rol de usuario no definido.',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
    
            if ((int) $_SESSION['id_rol'] !== 3) {
                http_response_code(403);
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'No tienes permisos para inscribirte.',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
    
            $id_evento_int = (int) $id_evento;
            if ($id_evento_int <= 0) {
                http_response_code(400);
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'ID de evento inválido.',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
    
            $id_usuario = (int) $_SESSION['id_usuario'];
            $result = $this->guestEventService->registerToEvent($id_usuario, $id_evento_int);
    
            $statusCode = 200;
            if (isset($result['status']) && $result['status'] === 'error') {
                $msg = $result['message'] ?? '';
                if (strpos($msg, 'Ya estás inscrito') !== false) {
                    $statusCode = 409;
                } elseif (strpos($msg, 'no tiene cupos') !== false) {
                    $statusCode = 409;
                } elseif (strpos($msg, 'no existe') !== false) {
                    $statusCode = 404;
                } else {
                    $statusCode = 400;
                }
            }
    
            http_response_code($statusCode);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status'  => 'error',
                'message' => 'Error interno del servidor.',
            ], JSON_UNESCAPED_UNICODE);
        }
    
        exit;
    }
}