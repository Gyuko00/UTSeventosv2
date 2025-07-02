<?php

/* 
Router principal del sistema
Interpreta rutas tipo /modulo/metodo y llama al controlador correspondiente.
*/

class Router
{
    private string $module = 'auth';
    private string $controller = 'AuthController';
    private string $method = 'loginForm';
    private array $params = [];

    public function __construct()
    {
        $this->parseUrl();
    }

    private function parseUrl(): void
    {
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
        $uri = explode('?', trim($requestUri, '/'))[0];
        $segments = explode('/', $uri);

        // Módulo (subcarpeta en /modules)
        if (!empty($segments[0])) {
            $this->module = strtolower($segments[0]);
            array_shift($segments);
        }

        // Controlador (asumimos que tiene el mismo nombre del módulo)
        $this->controller = ucfirst($this->module) . 'Controller';

        // Método
        if (!empty($segments[0])) {
            $this->method = $segments[0];
            array_shift($segments);
        }

        // Parámetros
        $this->params = $segments;
    }

    public function run(): void
    {
        $controllerPath = __DIR__ . "/modules/{$this->module}/controllers/{$this->controller}.php";

        if (!file_exists($controllerPath)) {
            $this->redirectToError("Controlador no encontrado: {$this->controller} en módulo {$this->module}");
        }

        require_once $controllerPath;

        if (!class_exists($this->controller)) {
            $this->redirectToError("Clase no encontrada: {$this->controller}");
        }

        $db = new Database();
        $controllerInstance = new $this->controller($db->getConnection());

        if (!method_exists($controllerInstance, $this->method)) {
            $this->redirectToError("Método no encontrado: {$this->method}");
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function redirectToError(string $message): void
    {
        header('HTTP/1.0 404 Not Found');
        echo "<h2>Error de ruta</h2><p>{$message}</p>";
        exit();
    }
}
