<?php

class ActivateUserAdminController extends Controller {

    private AdminUserService $userService;
    
    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }
    
    public function activarUsuario(int $id)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_clean();

            $result = $this->userService->activateUser($_SESSION['id_usuario'], $id);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($result);
            exit;
        }

        http_response_code(405);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        exit;
    }
}