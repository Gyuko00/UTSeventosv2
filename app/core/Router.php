/*                                                                        
Router.php                                                                 

Clase Router encargada de interpretar la URL y dirigirla al controlador    
y método correspondiente. Compatible con subcarpetas, maneja errores,      
e invoca controladores con inyección de conexión a BD.                                                          
*/                                                                        

<?php

class Router
{
    private string $controller = 'PageController';
    private string $method = 'index';
    private array $params = [];

    public function __construct()
    {
        $this->parseUrl();
    }

    private function parseUrl(): void
    {
        // Asegura compatibilidad si tu proyecto está en subcarpetas
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestUri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
        $uri = explode('?', trim($requestUri, '/'))[0];
        $segments = explode('/', $uri);

        // Controlador
        if (!empty($segments[0])) {
            $this->controller = ucfirst($segments[0]) . 'Controller';
            array_shift($segments);
        }

        // Método
        if (!empty($segments[0])) {
            $this->method = $segments[0];
            array_shift($segments);
        }

        // Parámetros restantes
        $this->params = $segments;
    }

    public function run(): void
    {
        // Ruta del controlador (ajústala si mueves tus controladores)
        $controllerFile = __DIR__ . '/../app/controllers/' . $this->controller . '.php';

        if (!file_exists($controllerFile)) {
            $this->redirectToError("Controlador no encontrado: {$this->controller}");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($this->controller)) {
            $this->redirectToError("Clase no encontrada: {$this->controller}");
            return;
        }

        $database = new Database();
        $connection = $database->getConnection();
        $controllerInstance = new $this->controller($connection);

        if (!method_exists($controllerInstance, $this->method)) {
            $this->redirectToError("Método no encontrado: {$this->method}");
            return;
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function redirectToError(string $message): void
    {
        // Puedes redirigir a un controlador de errores real o simplemente mostrar mensaje
        header('HTTP/1.0 404 Not Found');
        echo "<h2>Error de ruta</h2><p>{$message}</p>";
        // header("Location: " . URL_PATH . "/page/index"); // si deseas redirigir en lugar de mostrar
        exit();
    }
}
