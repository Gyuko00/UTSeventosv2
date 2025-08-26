<?php

class UserController extends Controller
{
    private AdminEventService $eventService;
    private AdminUserService $userService;
    private EventGuestService $guestEventService;
    private UserInscriptionController $inscriptionController;
    private UserEventDetailController $eventDetail;
    private GuestProfileService $profileService;
    private GuestProfileModel $profileModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
        $this->userService = new AdminUserService($db);
        $this->guestEventService = new EventGuestService($db);
        $this->inscriptionController = new UserInscriptionController($db);
        $this->eventDetail = new UserEventDetailController($db);
        $this->profileService = new GuestProfileService($db);
        $this->profileModel = new GuestProfileModel($db);
    }

    public function home()
    {
        $this->verificarAccesoConRoles([3]);
        $eventos = $this->eventService->getAllEvents();
        $this->view('user/home', ['eventos' => $eventos['data'] ?? []], 'user');
    }

    public function inscribirme($id_evento)
    {
        $this->verificarAccesoConRoles([3]);
        return $this->inscriptionController->inscribirme($id_evento);
    }

    public function detalleEvento(int $id)
    {
        $this->verificarAccesoConRoles([3]);
        return $this->eventDetail->detalleEvento($id);
    }

    public function perfil()
    {
        $this->verificarAccesoConRoles([3]);

        $data = $this->profileService->obtenerPerfil();
        $this->view('user/perfil', $data, 'user');
    }

    public function actualizarPerfil()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/json; charset=UTF-8');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Método no permitido'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $this->verificarAccesoConRoles([3]);

            $result = $this->profileService->actualizarPerfil($_POST);

            if ($result['status'] === 'success') {
                http_response_code(200);
            } else {
                http_response_code(400);
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'debug' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    public function cambiarContrasena()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/json; charset=UTF-8');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Método no permitido'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $this->verificarAccesoConRoles([3]);

            $result = $this->profileService->cambiarContrasena($_POST);

            switch ($result['status']) {
                case 'success':
                    http_response_code(200);
                    break;
                case 'info':
                    http_response_code(200);
                    break;
                case 'error':
                    http_response_code(400);
                    break;
                default:
                    http_response_code(500);
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], JSON_UNESCAPED_UNICODE);

            error_log('Error en cambiarContrasena: ' . $e->getMessage());
        }

        exit;
    }

    public function obtenerMisEventos()
    {
        while (ob_get_level() > 0) { ob_end_clean(); }
    
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, must-revalidate');
    
        try {
            $this->verificarAccesoConRoles([3]);
    
            $id_usuario  = (int)$_SESSION['id_usuario'];
            $id_invitado = $this->profileModel->getInvitadoIdByUsuario($id_usuario);
    
            $debugInfo = [
                'id_usuario_sesion' => $id_usuario,
                'id_invitado_resuelto' => $id_invitado,
                'session_data' => $_SESSION
            ];
    
            // Muestras
            $testSql   = 'SELECT id_invitado_evento, id_invitado, id_evento FROM invitados_evento LIMIT 10';
            $testStmt  = $this->profileModel->query($testSql);
            $invitadosData = $testStmt->fetchAll(PDO::FETCH_ASSOC);
    
            $debugInfo['tabla_invitados_muestra'] = $invitadosData;
    
            if ($id_invitado) {
                $countSql = 'SELECT COUNT(*) as total FROM invitados_evento WHERE id_invitado = :id_invitado';
                $countStmt= $this->profileModel->query($countSql, [':id_invitado' => $id_invitado]);
                $countRes = $countStmt->fetch(PDO::FETCH_ASSOC);
                $debugInfo['registros_para_invitado'] = (int)($countRes['total'] ?? 0);
            } else {
                $debugInfo['registros_para_invitado'] = 0;
                $debugInfo['nota'] = 'Usuario sin fila en tabla invitados';
            }
    
            $resultado = $this->profileService->getMisEventos();
            $resultado['debug_info'] = $debugInfo;
    
            http_response_code($resultado['status'] === 'success' ? 200 : 400);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'debug' => $e->getMessage(),
                'debug_info' => [
                    'id_usuario_sesion' => $_SESSION['id_usuario'] ?? 'no definido',
                    'error_completo' => $e->getTraceAsString()
                ]
            ], JSON_UNESCAPED_UNICODE);
        }
    
        exit;
    }
    
    
    public function cerrarSesion()
    {
        session_destroy();
        header('Location: ' . URL_PATH . '/auth/login');
        exit;
    }
}
