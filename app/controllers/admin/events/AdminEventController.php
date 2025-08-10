<?php

/**
 * AdminEventController: controlador para gestión de eventos desde el administrador.
 */
class AdminEventController extends Controller
{
    private AdminEventService $eventService;
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
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

        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/listarEventos');
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

        $this->view('admin/detalle_evento', ['evento' => $datos], 'admin');
    }

    public function crearEvento()
    {
        $this->verificarAccesoConRoles([1]);

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

    public function editarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // DEBUG: Mostrar datos en la respuesta JSON para ver qué está pasando
            $debugInfo = [
                'POST_data' => $_POST,
                'id_parametro' => $id,
                'id_usuario_sesion' => $_SESSION['id_usuario'] ?? 'NO_EXISTE',
                'tipo_id_parametro' => gettype($id),
                'tipo_id_usuario_sesion' => gettype($_SESSION['id_usuario'] ?? null)
            ];
            
            $eventData = $_POST['event'] ?? [];
            
            // DEBUG: Agregar info del eventData
            $debugInfo['eventData_original'] = $eventData;
            $debugInfo['eventData_tipo'] = gettype($eventData);
            $debugInfo['eventData_vacio'] = empty($eventData);
            
            // Limpiar eventData - remover id_usuario_creador del eventData si existe
            if (isset($eventData['id_usuario_creador'])) {
                unset($eventData['id_usuario_creador']);
                $debugInfo['eventData_limpiado'] = 'Se removió id_usuario_creador del eventData';
            }
            
            // Agregar id_usuario_creador al eventData
            $eventData['id_usuario_creador'] = $_SESSION['id_usuario'];
            
            $debugInfo['eventData_final'] = $eventData;
            
            // Verificar que eventData sea un array y no esté vacío
            if (!is_array($eventData) || empty($eventData)) {
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Datos del evento inválidos o vacíos',
                        'debug' => $debugInfo
                    ]);
                    exit;
                }
                
                $this->view('admin/editar_evento', ['error' => 'Datos inválidos', 'debug' => $debugInfo], 'admin');
                return;
            }
    
            // DEBUG: Verificar los parámetros que vamos a pasar al service
            $debugInfo['parametros_al_service'] = [
                'param1_idUsuario' => $_SESSION['id_usuario'],
                'param1_tipo' => gettype($_SESSION['id_usuario']),
                'param2_id' => $id,
                'param2_tipo' => gettype($id),
                'param3_eventData' => $eventData,
                'param3_tipo' => gettype($eventData)
            ];
    
            try {
                $result = $this->eventService->updateEvent($_SESSION['id_usuario'], $id, $eventData);
            } catch (Exception $e) {
                $debugInfo['excepcion'] = $e->getMessage();
                $debugInfo['trace'] = $e->getTraceAsString();
                
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error en el service: ' . $e->getMessage(),
                        'debug' => $debugInfo
                    ]);
                    exit;
                }
                
                $this->view('admin/editar_evento', ['error' => $e->getMessage(), 'debug' => $debugInfo], 'admin');
                return;
            }
    
            // Verificar si es una petición AJAX
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
    
                if ($result['status'] === 'success') {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Evento actualizado correctamente',
                        'redirect' => URL_PATH . '/admin/listarEventos',
                        'debug' => $debugInfo
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $result['message'],
                        'debug' => $debugInfo
                    ]);
                }
                exit;
            }
    
            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Evento actualizado correctamente';
                $this->redirect('admin/listarEventos');
            }
    
            $this->view('admin/editar_evento', ['error' => $result['message'], 'debug' => $debugInfo], 'admin');
            return;
        }
    
        $evento = $this->eventService->getEventById($id);
        if ($evento['status'] !== 'success') {
            $_SESSION['error_message'] = $evento['message'];
            $this->redirect('admin/listarEventos');
        }
    
        $this->view('admin/editar_evento', ['evento' => $evento['data']], 'admin');
    }

    public function eliminarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);
    
        // Verificar si es una petición AJAX
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            
            header('Content-Type: application/json');
            
            // Pasar el ID del usuario admin que está eliminando el evento
            $result = $this->eventService->deleteEvent($_SESSION['id_usuario'], $id);
            
            if ($result['status'] === 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Evento eliminado correctamente'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $result['message']
                ]);
            }
            exit;
        }
    
        // Si no es AJAX, procesar normalmente
        $result = $this->eventService->deleteEvent($_SESSION['id_usuario'], $id);
    
        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Evento eliminado correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }
    
        $this->redirect('admin/listarEventos');
    }
}
