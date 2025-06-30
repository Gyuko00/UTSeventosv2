<!--
Response.php

Clase para gestionar respuestas HTTP: redirecciones, headers, JSON,
 estados de error, etc. Permite centralizar la salida del servidor.
-->

<?php

class Response
{
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    public static function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function status(int $code): void
    {
        http_response_code($code);
    }

    public static function abort(int $code, string $message = ''): void
    {
        http_response_code($code);
        echo "<h1>Error $code</h1><p>$message</p>";
        exit;
    }
}
