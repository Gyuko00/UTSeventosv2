<?php

class UserController extends Controller
{
    private EventGuestService $eventService;
    private UserInscriptionController $inscriptionController;
    private UserEventDetailController $eventDetail;
    private GuestProfileService $profileService;
    private GuestProfileModel $profileModel;
    private EventGuestModel $eventGuest;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new EventGuestService($db);
        $this->inscriptionController = new UserInscriptionController($db);
        $this->eventDetail = new UserEventDetailController($db);
        $this->profileService = new GuestProfileService($db);
        $this->profileModel = new GuestProfileModel($db);
        $this->eventGuest = new EventGuestModel($db);
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
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, must-revalidate');

        try {
            $this->verificarAccesoConRoles([3]);

            $id_usuario = (int) $_SESSION['id_usuario'];
            $id_invitado = $this->profileModel->getInvitadoIdByUsuario($id_usuario);

            $debugInfo = [
                'id_usuario_sesion' => $id_usuario,
                'id_invitado_resuelto' => $id_invitado,
                'session_data' => $_SESSION
            ];

            // Muestras
            $testSql = 'SELECT id_invitado_evento, id_invitado, id_evento FROM invitados_evento LIMIT 10';
            $testStmt = $this->profileModel->query($testSql);
            $invitadosData = $testStmt->fetchAll(PDO::FETCH_ASSOC);

            $debugInfo['tabla_invitados_muestra'] = $invitadosData;

            if ($id_invitado) {
                $countSql = 'SELECT COUNT(*) as total FROM invitados_evento WHERE id_invitado = :id_invitado';
                $countStmt = $this->profileModel->query($countSql, [':id_invitado' => $id_invitado]);
                $countRes = $countStmt->fetch(PDO::FETCH_ASSOC);
                $debugInfo['registros_para_invitado'] = (int) ($countRes['total'] ?? 0);
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

    public function cancelarInscripcion($id_evento)
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

            $id_usuario = (int) $_SESSION['id_usuario'];
            $id_evento = (int) $id_evento;

            if (!$id_evento) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'ID de evento inválido'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $resultado = $this->eventService->cancelarInscripcionUsuario($id_evento, $id_usuario);

            if ($resultado['status'] === 'success') {
                http_response_code(200);
            } else {
                http_response_code(400);
            }

            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], JSON_UNESCAPED_UNICODE);
        }

        exit;
    }

    public function generarEntrada($id_evento)
    {
        // Blindar salida binaria
        while (ob_get_level() > 0) { ob_end_clean(); }
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        if (ini_get('zlib.output_compression')) ini_set('zlib.output_compression', '0');
        ignore_user_abort(true);
    
        try {
            // Auth
            if (!isset($_SESSION['id_usuario']) || (int)$_SESSION['id_rol'] !== 3) {
                http_response_code(401); exit('Unauthorized');
            }
    
            $id_evento  = (int)$id_evento;
            $id_usuario = (int)$_SESSION['id_usuario'];
            if ($id_evento <= 0) { http_response_code(400); exit('Bad request'); }
    
            // Verificar inscripción
            $inv = $this->eventGuest->getInvitacionByUsuarioEvento($id_usuario, $id_evento);
            if (!$inv) { http_response_code(404); exit('Not found'); }
    
            // Datos para el nombre del archivo
            $evento = $this->eventService->getEventById($id_evento);
            $eventoTitulo = 'evento';
            if (($evento['status'] ?? '') === 'success' && !empty($evento['data']['titulo_evento'])) {
                $eventoTitulo = $this->sanitizeFilename($evento['data']['titulo_evento']);
            }
    
            // Token persistente
            $token = $inv['token'] ?: bin2hex(random_bytes(32));
            if (empty($inv['token'])) {
                $this->eventGuest->setTokenInvitadoEvento((int)$inv['id_invitado_evento'], $token);
            }
    
            // URL que irá dentro del QR
            $payloadUrl = rtrim(URL_PATH, '/').'/control/marcarAsistencia/'.$token;
    
            // phpqrcode
            $projectRoot = realpath(__DIR__.'/../../../');
            $qrlib = $projectRoot.'/public/lib/phpqrcode/qrlib.php';
            require_once $qrlib;
    
            // Generar PNG en archivo temporal
            $tmp = tempnam(sys_get_temp_dir(), 'qr_');
            $tmpPng = $tmp.'.png';
            rename($tmp, $tmpPng);
    
            // Generar QR
            QRcode::png($payloadUrl, $tmpPng, QR_ECLEVEL_L, 6, 2);
    
            if (!file_exists($tmpPng)) {
                http_response_code(500); exit('QR generation failed');
            }
    
            // Validar firma PNG
            $fh = fopen($tmpPng, 'rb');
            $sig = fread($fh, 8);
            fclose($fh);
            if ($sig !== "\x89PNG\x0D\x0A\x1A\x0A") {
                @unlink($tmpPng);
                http_response_code(500); exit('Invalid PNG');
            }
    
            // Nombre de descarga
            $nombreUsuario = $this->sanitizeFilename($_SESSION['nombre'] ?? 'usuario');
            $fecha = date('Y-m-d_H-i-s');
            $filename = "entrada-{$eventoTitulo}-{$nombreUsuario}-{$fecha}.png";
    
            // Limpiar cualquier output pendiente
            while (ob_get_level() > 0) { ob_end_clean(); }
            
            // Headers
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Length: ' . filesize($tmpPng));
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Pragma: no-cache');
    
            // Enviar archivo
            readfile($tmpPng);
            
            // Limpiar archivo temporal
            @unlink($tmpPng);
            exit;
    
        } catch (\Throwable $e) {
            http_response_code(500); exit('Server error');
        }
    }

    private function sanitizeFilename(string $filename): string
    {
        // Reemplazar caracteres especiales y espacios
        $filename = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $filename);

        // Eliminar múltiples guiones bajos consecutivos
        $filename = preg_replace('/_+/', '_', $filename);

        // Remover guiones bajos al inicio y final
        $filename = trim($filename, '_');

        // Limitar longitud
        return substr($filename, 0, 30);
    }
}
