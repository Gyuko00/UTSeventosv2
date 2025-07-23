<?php

/**
 * Middleware para verificar acceso según roles
 * Redirige al login si no hay sesión iniciada, o a 404 si no tiene permisos.
 */
class AuthMiddleware {

    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function verificarAccesoConRoles(
        array $rolesPermitidos = []
    ): void {
        $loginRedirect = URL_PATH . '/auth/login';
        $deniedRedirect = URL_PATH . '/auth/notFound';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        error_log("AuthMiddleware - Datos de sesión: " . json_encode($_SESSION ?? 'NULL'));

        if (
            empty($_SESSION['id_usuario']) ||
            empty($_SESSION['id_rol'])
        ) {
            header("Location: {$loginRedirect}");
            exit;
        }

        if (empty($rolesPermitidos)) {
            return;
        }

        if (!in_array($_SESSION['id_rol'], $rolesPermitidos, true)) {
            header("Location: {$deniedRedirect}");
            exit;
        }
    }
}