<?php
/**
 * Router principal del sistema: resuelve y ejecuta la ruta /modulo/metodo/parametros.
 * Siempre busca el controlador {Modulo}Controller dentro de app/controllers/{modulo}/
 * Ejecuta el método solicitado con los parámetros de la URL.
 */
class Router 
{

    private $module = 'auth';
    private $controller = 'AuthController';
    private $method = 'login';
    private $params = [];

    public function __construct()
    {
        $this->parseUrl();
    }

    private function parseUrl()
    {
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
        $uri = explode('?', trim($requestUri, '/'))[0];
        $segments = array_values(array_filter(explode('/', $uri)));

        if (!empty($segments)) {
            $this->module = strtolower($segments[0]);
            $this->controller = ucfirst($this->module) . 'Controller';
            array_shift($segments);
        }

        if (!empty($segments)) {
            $this->method = $segments[0];
            array_shift($segments);
        }

        $this->params = $segments;
    }

    public function run()
    {
        $controllerPath = __DIR__ . "/../controllers/{$this->module}/{$this->controller}.php";

        if (!file_exists($controllerPath)) {
            $this->error404("Controlador no encontrado: {$this->controller} en módulo {$this->module}");
        }

        require_once $controllerPath;

        if (!class_exists($this->controller)) {
            $this->error404("Clase no encontrada: {$this->controller}");
        }
        
        $pdo = (new Database())->getConnection();
        $controllerInstance = new $this->controller($pdo);

        if (!method_exists($controllerInstance, $this->method)) {
            $this->error404();
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function error404()
    {
        header('Location:' . URL_PATH . '/auth/notFound');
    }
}
