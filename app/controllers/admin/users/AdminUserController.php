<?php

/**
 * AdminUserController: controlador para gestión de usuarios, invitados y ponentes desde el administrador.
 */
class AdminUserController extends Controller
{
    private AdminUserService $userService;
    private ListUsersAdminController $listarUsuarios;
    private CreateUserAdminController $crearUsuario;
    private EditUserAdminController $editarUsuario;
    private DeleteUserAdminController $eliminarUsuario;
    private ActivateUserAdminController $activarUsuario;
    private UserDetailAdminController $detalleUsuario;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userService = new AdminUserService($db);
        $this->listarUsuarios = new ListUsersAdminController ($db);
        $this->crearUsuario = new CreateUserAdminController($db);
        $this->editarUsuario = new EditUserAdminController($db);
        $this->eliminarUsuario = new DeleteUserAdminController($db);
        $this->activarUsuario = new ActivateUserAdminController($db);
        $this->detalleUsuario = new UserDetailAdminController($db);
    }

    public function listarUsuarios()
    {
        $this->verificarAccesoConRoles([1]);

        return $this->listarUsuarios->listarUsuarios();
    }

    public function detalleUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->detalleUsuario->detalleUsuario($id);
    }

    public function activarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->activarUsuario->activarUsuario($id);
    }

    public function crearUsuario()
    {
        $this->verificarAccesoConRoles([1]);

        $this->crearUsuario->crearUsuario();
    }

    public function editarUsuario(int $id)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->editarUsuario->editarUsuario($id);
    }

    public function eliminarUsuario($id = null)
    {
        $this->verificarAccesoConRoles([1]);

        return $this->eliminarUsuario->eliminarUsuario($id);
    }
}
