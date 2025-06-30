<!--
View.php

Clase para renderizar vistas organizadas por módulos con layouts generales.
Permite utilizar rutas tipo 'modulo/vista' y pasar datos al layout principal.
-->

<?php

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        // Soporta sintaxis tipo 'auth/login' => módulo 'auth', vista 'login'
        $viewParts = explode('/', $view);
        if (count($viewParts) !== 2) {
            die("Error: Formato de vista inválido. Usa 'modulo/vista'");
        }

        [$module, $viewName] = $viewParts;

        $viewPath = __DIR__ . "/../app/modules/{$module}/views/{$viewName}.view.php";
        $layoutPath = __DIR__ . "/../views/layouts/{$layout}.layout.php";

        if (!file_exists($viewPath)) {
            die("Error: Vista no encontrada ($viewPath)");
        }

        if (!file_exists($layoutPath)) {
            die("Error: Layout no encontrado ($layoutPath)");
        }

        extract($data);
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        require $layoutPath;
    }
}
