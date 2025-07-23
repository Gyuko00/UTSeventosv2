<?php
/**
 * Controller: clase base para controladores del sistema.
 * Proporciona acceso a la conexión PDO y al motor de renderizado de vistas.
 */

abstract class Controller
{
    protected PDO $db;
    protected Render $render;
    private AuthMiddleware $auth;

    public function __construct(PDO $db)
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->render = new Render();
        $this->auth = new AuthMiddleware($db);
    }

    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        $this->render->render($view, $data, $layout);
    }

    protected function verificarAccesoConRoles(array $roles): void
    {
        $this->auth->verificarAccesoConRoles($roles);
    }
    
    protected function redirect(string $url): void
    {
        header('Location:' . URL_PATH . $url);
        exit;
    }
}
