<?php

class DeleteEventAdminController extends Controller
{
    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventService = new AdminEventService($db);
    }

    public function eliminarEvento(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');

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

        $result = $this->eventService->deleteEvent($_SESSION['id_usuario'], $id);

        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Evento eliminado correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }

        $this->redirect('admin/listarEventos');
    }
}
