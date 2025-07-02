<?php
session_start();

/**
 * Verifica si el usuario tiene un rol específico para acceder a una ruta.
 *
 * @param int $rolEsperado Rol necesario para acceder (1: admin, 2: ponente, 3: invitado, 4: control)
 */
function verificarRol($rolEsperado)
{
    if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != $rolEsperado) {
        header('Location: /auth/loginForm');
        exit;
    }
}

?>