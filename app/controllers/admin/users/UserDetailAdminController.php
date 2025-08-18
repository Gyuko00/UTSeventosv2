<?php

class UserDetailAdminController extends Controller {

    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }

    public function detalleUsuario(int $id)
    {
    
        $usuario = $this->userService->getUserById($id);
        if ($usuario['status'] !== 'success') {
            $_SESSION['error_message'] = $usuario['message'];
            $this->redirect('admin/listarUsuarios');
        }
    
        $datos = $usuario['data'];
    
        if ((int)$datos['id_rol'] === 3) {
            $invitado = $this->userService->getGuestByPersonId($datos['id_persona']);
            if ($invitado['status'] === 'success') {
                $datos = array_merge($datos, $invitado['data']);
            }
        }
    
        if ((int)$datos['id_rol'] === 2) {
            $ponente = $this->userService->getSpeakerByPersonId($datos['id_persona']);
            if ($ponente['status'] === 'success') {
                $datos = array_merge($datos, $ponente['data']);
            }
        }
    
        $this->view('admin/detalle_usuario', ['usuario' => $datos], 'admin');
    }
}