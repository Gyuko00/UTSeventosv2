<?php

/**
 * AdminEventGuestController: controlador para gestionar invitados asignados a eventos desde el administrador.
 */
class AdminEventGuestController extends Controller
{
    private AdminEventGuestService $eventGuestService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventGuestService = new AdminEventGuestService($db);
    }

    public function listarInvitados()
    {
        $this->verificarAccesoConRoles([1]);

        $invitados = $this->eventGuestService->listAllGuests();
        $this->view('admin/listar_invitados', ['invitados' => $invitados['data'] ?? []], 'admin');
    }

    public function detalleInvitado(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $invitado = $this->eventGuestService->getGuest($id);
        if ($invitado['status'] !== 'success') {
            $_SESSION['error_message'] = $invitado['message'];
            $this->redirect('admin/listar_invitados');
        }

        $this->view('admin/detalle_invitado', ['invitado' => $invitado['data']], 'admin');
    }

    public function asignarInvitado()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['guest'] ?? [];

            $result = $this->eventGuestService->assignGuest(
                $_SESSION['id_usuario'],
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Invitado asignado correctamente';
                $this->redirect('admin/listar_invitados');
            }

            $this->view('admin/asignar_invitado', ['error' => $result['message']], 'admin');
            return;
        }

        $this->view('admin/asignar_invitado', [], 'admin');
    }

    public function editarAsignacionInvitado(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['guest'] ?? [];

            $result = $this->eventGuestService->updateGuestAssignment(
                $_SESSION['id_usuario'],
                $id,
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Asignación de invitado actualizada correctamente';
                $this->redirect('admin/listar_invitados');
            }

            $this->view('admin/editar_asignacion_invitado', ['error' => $result['message']], 'admin');
            return;
        }

        $invitado = $this->eventGuestService->getGuest($id);
        if ($invitado['status'] !== 'success') {
            $_SESSION['error_message'] = $invitado['message'];
            $this->redirect('admin/listar_invitados');
        }

        $this->view('admin/editar_asignacion_invitado', ['invitado' => $invitado['data']], 'admin');
    }

    public function eliminarAsignacionPonente(int $id) 
    {
        $this->verificarAccesoConRoles([1]);
    
        $result = $this->eventSpeakerService->deleteSpeakerEvent($_SESSION['id_usuario'], $id);
    
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                  && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode($result);
            return;
        }
    
        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Asignación eliminada correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'] ?? 'Error al eliminar asignación';
        }
    
        $this->redirect('/admin/listarPonentes');
    }
    
}
