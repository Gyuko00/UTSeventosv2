<?php

class ControlController extends Controller {

    private EventControlService $eventService;
    private ControlEventDetailController $eventDetail;
    
    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->eventDetail = new ControlEventDetailController($db);
        $this->eventService = new EventControlService($db);
    }

    public function home()
    {
        $this->verificarAccesoConRoles([4]);
        $eventos = $this->eventService->getAllEvents();
        $this->view('control/home', ['eventos' => $eventos['data'] ?? []], 'control');
    }

    
    public function detalleEvento(int $id)
    {
        $this->verificarAccesoConRoles([4]);
        return $this->eventDetail->detalleEvento($id);
    }

    public function marcarAsistencia($token = null) {
        $token = is_string($token) ? trim($token) : '';

        if ($token === '') {
            http_response_code(400);
            $data = [
                'status'  => 'error',
                'title'   => 'Token no válido',
                'message' => 'No se recibió un token válido en la URL.'
            ];
            $this->view('control/marcar_asistencia', $data, 'control');
            return;
        }

        try {
            $res = $this->eventService->markByToken($token);

            $data = [
                'status'   => $res['status'],
                'code'     => $res['code'] ?? null,
                'title'    => $res['status'] === 'success' ? '¡Asistencia registrada!' :
                              ($res['status'] === 'info' ? 'Asistencia ya registrada' : 'No se pudo registrar'),
                'message'  => $res['message'] ?? '',
                'evento'   => $res['data']['titulo_evento'] ?? null,
                'fecha'    => $res['data']['fecha'] ?? null,
                'hora_ini' => $res['data']['hora_inicio'] ?? null,
                'hora_fin' => $res['data']['hora_fin'] ?? null,
                'nombre'   => trim(($res['data']['nombres'] ?? '').' '.($res['data']['apellidos'] ?? ''))
            ];

            $this->view('control/marcar_asistencia', $data, 'control'); 
        } catch (Throwable $e) {
            http_response_code(500);
            $this->view('control/marcar_asistencia', [
                'status'  => 'error',
                'title'   => 'Error del servidor',
                'message' => 'Ha ocurrido un error inesperado.'
            ], 'control');
        }
    }

    public function cerrarSesion()
    {
        session_destroy();
        header('Location: ' . URL_PATH . '/auth/login');
        exit;
    }

}