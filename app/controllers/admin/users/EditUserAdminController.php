<?php

class EditUserAdminController extends Controller
{
    private AdminUserService $userService;


    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }

    public function editarUsuario(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Datos JSON inválidos'
                ]);
                exit;
            }
    
            $personData = $data['person'] ?? [];
            $userData = $data['user'] ?? [];
            $roleData = $data['roleSpecific'] ?? [];
    
            $result = $this->userService->updateUserWithRole(
                $_SESSION['id_usuario'],
                $id,
                $personData,
                $userData,
                $roleData
            );
    
            header('Content-Type: application/json');
            if ($result['status'] === 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario actualizado correctamente',
                    'redirect' => URL_PATH . '/admin/listarUsuarios'
                ]);
            } else {
                echo json_encode($result);
            }
            exit;
        }
    
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
    
        $this->view('admin/editar_usuario', ['usuario' => $datos], 'admin');
    }
}
