<?php

require_once (__DIR__ . '/../../../core/Render.php');
require_once (__DIR__ . '/../services/UserService.php');
require_once (__DIR__ . '/../../../middleware/AuthMiddleware.php');

class UserController
{
    private $render;
    private $userService;

    public function __construct(PDO $db)
    {
        verificarAccesoConRoles([3]);
        $this->render = new Render();
        $this->userService = new UserService($db);
    }

    public function perfil()
    {
        $data = $this->userService->perfil();
        $this->render->render('user/perfil', $data, 'user');
    }

    public function editarPerfil()
    {
        $data = $this->userService->perfil();
        $this->render->render('user/editar_perfil', $data, 'user');
    }

    public function editarPerfilForm()
    {
        $this->userService->editarPerfilForm();
    }

    public function home()
    {
        $data = $this->userService->home();
        $this->render->render('user/home', $data, 'user');
    }

    public function misEventos()
    {
        $data = $this->userService->misEventos();
        $this->render->render('user/mis_eventos', $data, 'user');
    }

    public function inscribirEvento()
    {
        $this->userService->inscribirEvento();
    }

    public function cancelarInscripcion()
    {
        $this->userService->cancelarInscripcion();
    }

    public function evento()
    {
        try {
            $data = $this->userService->evento();
            $this->render->render('user/evento', $data, 'user');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
