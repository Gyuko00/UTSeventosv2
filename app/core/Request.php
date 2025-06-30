/*
Request.php

Clase para manejar todas las solicitudes HTTP entrantes: GET, POST,
PUT, DELETE y parámetros. Centraliza el acceso y validación de datos.
*/

<?php

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $files;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
    }

    public function get(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function is(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key]) || isset($this->get[$key]);
    }
}
