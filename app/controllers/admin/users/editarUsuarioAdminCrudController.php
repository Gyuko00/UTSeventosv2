<?php

class editarUsuarioAdminCrudController extends Controller
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
            $personData = $_POST['person'] ?? [];
            $userData = $_POST['user'] ?? [];
            $roleData = $_POST['roleSpecific'] ?? [];

            $result = $this->userService->updateUserWithRole(
                $_SESSION['id_usuario'],
                $id,
                $personData,
                $userData,
                $roleData
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Usuario actualizado correctamente';
                $this->redirect('admin/usuarios');
            }

            $this->view('admin/editar_usuario', ['error' => $result['message']], 'admin');
            return;
        }

        $usuario = $this->userService->getUserById($id);
        if ($usuario['status'] !== 'success') {
            $_SESSION['error_message'] = $usuario['message'];
            $this->redirect('admin/usuarios');
        }

        $this->view('admin/editar_usuario', ['usuario' => $usuario['data']], 'admin');
    }
}
