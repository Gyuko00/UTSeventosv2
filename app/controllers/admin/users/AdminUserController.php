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

    public function detalleUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $usuario = $this->userService->getUserById($id);
        if ($usuario['status'] !== 'success') {
            $_SESSION['error_message'] = $usuario['message'];
            $this->redirect('admin/usuarios');
        }

        $this->view('admin/detalle_usuario', ['usuario' => $usuario['data']], 'admin');
    }

    public function crearUsuario()
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/crear_usuario', [], 'admin');
            return;
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        try {
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-cache, must-revalidate');

            $rawInput = file_get_contents('php://input');

            if (empty($rawInput)) {
                throw new Exception('No se recibieron datos en el cuerpo de la solicitud');
            }

            $data = json_decode($rawInput, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            $personData = $data['person'] ?? [];
            $userData = $data['user'] ?? [];
            $roleData = $data['roleSpecific'] ?? [];

            if (empty($personData) || empty($userData)) {
                throw new Exception('Datos del formulario incompletos');
            }

            $filteredRoleData = $this->filterRoleDataByRole($userData['id_rol'], $roleData);

            $result = $this->userService->createUserWithRole(
                $_SESSION['id_usuario'],
                $personData,
                $userData,
                $filteredRoleData
            );

            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = 'Usuario creado correctamente';

                $response = [
                    'status' => 'success',
                    'message' => 'Usuario creado correctamente',
                    'redirect' => '/utseventos/public/admin/listarUsuarios'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => $result['message']
                ];
            }

            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
            }

            $errorResponse = [
                'status' => 'error',
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ];

            echo json_encode($errorResponse);
            exit;
        }
    }

    private function filterRoleDataByRole(string $roleId, array $roleData): array
    {
        $filtered = [];

        switch ((int) $roleId) {
            case 2:  
                $speakerFields = ['tema', 'descripcion_biografica', 'especializacion', 'institucion_ponente'];
                foreach ($speakerFields as $field) {
                    if (!empty($roleData[$field])) {
                        $filtered[$field] = $roleData[$field];
                    }
                }
                break;

            case 3:  
                $guestFields = ['tipo_invitado', 'correo_institucional', 'programa_academico',
                    'nombre_carrera', 'jornada', 'facultad', 'cargo', 'sede_institucion'];
                foreach ($guestFields as $field) {
                    if (!empty($roleData[$field])) {
                        $filtered[$field] = $roleData[$field];
                    }
                }
                break;

            case 4:  
                break;
        }

        return $filtered;
    }

    private function responder($data)
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-cache, must-revalidate');
        }

        echo json_encode($data);
        exit;
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

    public function eliminarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        if ($_SESSION['id_usuario'] === $id) {
            $_SESSION['error_message'] = 'No puedes eliminar tu propio usuario';
            $this->redirect('admin/usuarios');
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

        $this->redirect('admin/usuarios');
    }
}
