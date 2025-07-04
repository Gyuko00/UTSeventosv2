<?php
session_start();

/*
 * Verifica si el usuario tiene un rol específico para acceder a una ruta.
 *
 * $rolEsperado Rol necesario para acceder (1: admin, 2: ponente, 3: invitado, 4: control)
 */

function verificarAccesoConRoles(array $rolesPermitidos = [])
{
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: /auth/loginForm');
        exit;
    }

    if (!empty($rolesPermitidos) && !in_array($_SESSION['rol'], $rolesPermitidos)) {
        header('Location: /auth/acceso_denegado');
        exit;
    }
}

?>