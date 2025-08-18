<?php

class DeleteUserAdminController extends Controller
{
    private AdminUserService $userService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
    }

    public function eliminarUsuario($id = null)
    {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        if (!$isAjax) {
            $_SESSION['error_message'] = 'Acceso no permitido por URL directa';
            $this->redirect('/admin/usuarios');
            return;
        }

        if ($isAjax) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
                return;
            }

            try {
                $input = json_decode(file_get_contents('php://input'), true);

                if (!isset($input['id_usuario']) || !is_numeric($input['id_usuario'])) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'ID de usuario no válido']);
                    return;
                }

                $id = (int) $input['id_usuario'];

                if ($_SESSION['id_usuario'] === $id) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'No puedes eliminar tu propio usuario']);
                    return;
                }

                if ($id === 1) {
                    http_response_code(403);
                    echo json_encode(['status' => 'error', 'message' => 'No se puede eliminar al usuario administrador']);
                    return;
                }

                $result = $this->userService->deleteUser($_SESSION['id_usuario'], $id);

                header('Content-Type: application/json');
                if ($result['status'] === 'success') {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }

                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error interno del servidor'
                ]);
            }
        } else {
            if (!$id || !is_numeric($id)) {
                $_SESSION['error_message'] = 'ID de usuario no válido';
                $this->redirect('/admin/usuarios');
                return;
            }

            $id = (int) $id;

            if ($_SESSION['id_usuario'] === $id) {
                $_SESSION['error_message'] = 'No puedes eliminar tu propio usuario';
                $this->redirect('/admin/usuarios');
                return;
            }

            if ($id === 1) {
                $_SESSION['error_message'] = 'No se puede eliminar al usuario administrador';
                $this->redirect('/admin/usuarios');
                return;
            }

            try {
                $result = $this->userService->deleteUser($_SESSION['id_usuario'], $id);

                if ($result['status'] === 'success') {
                    $_SESSION['success_message'] = 'Usuario eliminado correctamente';
                } else {
                    $_SESSION['error_message'] = $result['message'] ?? 'Error al eliminar el usuario';
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error interno del servidor';
            }

            $this->redirect('/admin/usuarios');
        }
    }
}
