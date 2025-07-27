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
            $this->redirect('admin/usuarios');
        }

        $this->view('admin/detalle_usuario', ['usuario' => $usuario['data']], 'admin');
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
