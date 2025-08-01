<?php

/**
 * AdminUserController: controlador para gestión de usuarios, invitados y ponentes desde el administrador.
 */
class AdminUserController extends Controller
{
    private AdminUserService $userService;
    private listarUsuariosAdminCrudController $listarUsuarios;
    private crearUsuarioAdminCrudController $crearUsuario;
    private editarUsuarioAdminCrudController $editarUsuario;
    private eliminarUsuarioAdminCrudController $eliminarUsuario;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
        $this->listarUsuarios = new listarUsuariosAdminCrudController($db);
        $this->crearUsuario = new crearUsuarioAdminCrudController($db);
        $this->editarUsuario = new editarUsuarioAdminCrudController($db);
        $this->eliminarUsuario = new eliminarUsuarioAdminCrudController($db);
    }

    public function listarUsuarios()
    {
        $this->verificarAccesoConRoles([1]);
        $this->listarUsuarios->listarUsuarios();
    }

    public function detalleUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);
    
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

    public function activarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);
    
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
    

    public function crearUsuario()
    {
        $this->verificarAccesoConRoles([1]);

        $this->crearUsuario->crearUsuario();
    }

    public function editarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        $this->editarUsuario->editarUsuario($id);
    }

    public function eliminarUsuario($id = null)
    {
        $this->verificarAccesoConRoles([1]);

        $this->eliminarUsuario->eliminarUsuario($id);
    }
}
