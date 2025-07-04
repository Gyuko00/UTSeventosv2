<?php

require_once (__DIR__ . '/../models/UserModel.php');

abstract class BaseUserService
{
    protected $userModel;

    public function __construct(PDO $db)
    {
        $this->userModel = new UserModel($db);
    }

    protected function iniciarSesionSegura(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function obtenerIdPersona(): array
    {
        $this->iniciarSesionSegura();
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        if (!$id_usuario) {
            header('Location: /auth/loginForm');
            exit;
        }

        $perfil = $this->userModel->obtenerPerfil($id_usuario);
        return ['id_usuario' => $id_usuario, 'id_persona' => $perfil['id_persona']];
    }
}
