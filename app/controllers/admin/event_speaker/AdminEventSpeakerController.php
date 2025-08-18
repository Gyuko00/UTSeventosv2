<?php

/**
 * AdminEventSpeakerController: controlador para gestionar ponentes asignados a eventos desde el administrador.
 */
class AdminEventSpeakerController extends Controller
{
    private AdminEventSpeakerService $speakerService;
    

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->speakerService = new AdminEventSpeakerService($db);
    }

    public function listarPonentes()
    {
        $this->verificarAccesoConRoles([1]);

        $ponentes = $this->speakerService->listAllSpeakers();
        $this->view('admin/ponentes_evento', ['ponentes' => $ponentes['data'] ?? []], 'admin');
    }

    public function detallePonente(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $ponente = $this->speakerService->getSpeaker($id);
        if ($ponente['status'] !== 'success') {
            $_SESSION['error_message'] = $ponente['message'];
            $this->redirect('admin/listar_ponentes');
        }

        $this->view('admin/detalle_ponente', ['ponente' => $ponente['data']], 'admin');
    }

    public function asignarPonente()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['speaker_event'] ?? [];

            $result = $this->speakerService->addSpeakerToEvent(
                $_SESSION['id_usuario'],
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Ponente asignado correctamente al evento';
                $this->redirect('admin/listar_ponentes');
            }

            $this->view('admin/asignar_ponente', ['error' => $result['message']], 'admin');
            return;
        }

        $this->view('admin/asignar_ponente', [], 'admin');
    }

    public function editarAsignacionPonente(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['speaker_event'] ?? [];

            $result = $this->speakerService->updateSpeakerEvent(
                $_SESSION['id_usuario'],
                $id,
                $data
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Asignación actualizada correctamente';
                $this->redirect('admin/listar_ponentes');
            }

            $this->view('admin/editar_asignacion_ponente', ['error' => $result['message']], 'admin');
            return;
        }

        $ponente = $this->speakerService->getSpeaker($id);
        if ($ponente['status'] !== 'success') {
            $_SESSION['error_message'] = $ponente['message'];
            $this->redirect('admin/listar_ponentes');
        }

        $this->view('admin/editar_asignacion_ponente', ['ponente' => $ponente['data']], 'admin');
    }

    public function eliminarAsignacionPonente(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $result = $this->speakerService->deleteSpeakerEvent($_SESSION['id_usuario'], $id);

        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Asignación eliminada correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }

        $this->redirect('admin/listar_ponentes');
    }
}
