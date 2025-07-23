<?php

/**
 * AdminUserController: controlador para gestión de usuarios, invitados y ponentes desde el administrador.
 */
class AdminUserController extends Controller
{
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }

    public function listarUsuarios()
    {
        $this->verificarAccesoConRoles([1]);

        $usuarios = $this->userService->getAllUsers();
        $this->view('admin/listar_usuarios', ['usuarios' => $usuarios['data'] ?? []], 'admin');
    }

    public function detalleUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $usuario = $this->userService->getUserById($id);
        if ($usuario['status'] !== 'success') {
            $_SESSION['error_message'] = $usuario['message'];
            $this->redirect('admin/listar_usuarios');
        }

        $this->view('admin/detalle_usuario', ['usuario' => $usuario['data']], 'admin');
    }

    public function crearUsuario()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $personData = $_POST['person'] ?? [];
            $userData = $_POST['user'] ?? [];
            $roleData = $_POST['roleSpecific'] ?? [];

            $result = $this->userService->createUserWithRole(
                $_SESSION['id_usuario'],
                $personData,
                $userData,
                $roleData
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Usuario creado correctamente';
                $this->redirect('admin/listar_usuarios');
            }

            $this->view('admin/crear_usuario', ['error' => $result['message']], 'admin');
            return;
        }

        $this->view('admin/crear_usuario', [], 'admin');
    }

    public function editarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

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
                $this->redirect('admin/listar_usuarios');
            }

            $this->view('admin/editar_usuario', ['error' => $result['message']], 'admin');
            return;
        }

        $usuario = $this->userService->getUserById($id);
        if ($usuario['status'] !== 'success') {
            $_SESSION['error_message'] = $usuario['message'];
            $this->redirect('admin/listar_usuarios');
        }

        $this->view('admin/editar_usuario', ['usuario' => $usuario['data']], 'admin');
    }

    public function eliminarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $result = $this->userService->deleteUser($_SESSION['id_usuario'], $id);

        if ($result['status'] === 'success') {
            $_SESSION['success_message'] = 'Usuario eliminado correctamente';
        } else {
            $_SESSION['error_message'] = $result['message'];
        }

        $this->redirect('admin/listar_usuarios');
    }
}
