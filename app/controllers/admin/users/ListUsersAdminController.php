<?php

class ListUsersAdminController extends Controller
{
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }

    public function listarUsuarios()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $usuarios = $this->userService->getAllUsers();
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $usuarios['status'],
                'usuarios' => $usuarios['data'] ?? []
            ]);
            return;
        }

        $usuariosResult = $this->userService->getAllUsers();
        $usuarios = $usuariosResult['data'] ?? [];

        $this->view('admin/usuarios', ['usuarios' => $usuarios], 'admin');
    }
}