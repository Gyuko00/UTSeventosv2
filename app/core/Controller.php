<?php
/**
 * Controller: clase base para controladores del sistema.
 * Proporciona acceso a la conexión PDO y al motor de renderizado de vistas.
 */

abstract class Controller
{
    protected PDO $db;
    protected Render $render;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->render = new Render();
    }

    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        $this->render->render($view, $data, $layout);
    }
    
    protected function redirect(string $url): void
    {
        header('Location:' . URL_PATH . $url);
        exit;
    }
}
