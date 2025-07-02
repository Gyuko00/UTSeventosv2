<?php

/*
Auth.php

Clase Auth para gestionar la autenticación de usuarios, inicio/cierre de
sesión, verificación de login y roles. Útil para controlar el acceso a
rutas y vistas protegidas.
*/

class Auth
{
    private static bool $sessionStarted = false;

    public static function start(): void
    {
        if (!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    public static function login(array $userData): void
    {
        self::start();
        $_SESSION['auth'] = [
            'id' => $userData['id'] ?? null,
            'nombre' => $userData['nombre'] ?? '',
            'email' => $userData['email'] ?? '',
            'rol' => $userData['rol'] ?? 'usuario',
            'loggedIn' => true
        ];
    }

    public static function logout(): void
    {
        self::start();
        session_destroy();
        $_SESSION = [];
    }

    public static function isLogged(): bool
    {
        self::start();
        return isset($_SESSION['auth']['loggedIn']) && $_SESSION['auth']['loggedIn'] === true;
    }

    public static function user(): ?array
    {
        self::start();
        return $_SESSION['auth'] ?? null;
    }

    public static function id(): ?int
    {
        return self::user()['id'] ?? null;
    }

    public static function rol(): ?string
    {
        return self::user()['rol'] ?? null;
    }

    public static function check(): void
    {
        if (!self::isLogged()) {
            header('Location: /login');  // Redirige al login si no está autenticado
            exit;
        }
    }

    public static function requireRole(string|array $roles): void
    {
        self::check();

        $userRol = self::rol();

        if (is_array($roles)) {
            if (!in_array($userRol, $roles)) {
                self::unauthorized();
            }
        } else {
            if ($userRol !== $roles) {
                self::unauthorized();
            }
        }
    }

    private static function unauthorized(): void
    {
        header('HTTP/1.1 403 Forbidden');
        echo '<h1>403 - Acceso no autorizado</h1>';
        exit;
    }
}
