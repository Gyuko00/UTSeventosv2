<?php

class editarEventoAdminCrudController extends Controller {

    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
    }

    public function editarEvento(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $debugInfo = [
                'POST_data' => $_POST,
                'id_parametro' => $id,
                'id_usuario_sesion' => $_SESSION['id_usuario'] ?? 'NO_EXISTE',
                'tipo_id_parametro' => gettype($id),
                'tipo_id_usuario_sesion' => gettype($_SESSION['id_usuario'] ?? null)
            ];
            
            $eventData = $_POST['event'] ?? [];
            
            $debugInfo['eventData_original'] = $eventData;
            $debugInfo['eventData_tipo'] = gettype($eventData);
            $debugInfo['eventData_vacio'] = empty($eventData);
            
            if (isset($eventData['id_usuario_creador'])) {
                unset($eventData['id_usuario_creador']);
                $debugInfo['eventData_limpiado'] = 'Se removió id_usuario_creador del eventData';
            }
            
            $eventData['id_usuario_creador'] = $_SESSION['id_usuario'];
            
            $debugInfo['eventData_final'] = $eventData;
            
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
}