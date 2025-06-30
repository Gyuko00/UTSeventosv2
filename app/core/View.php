/*
View.php

Clase para renderizar vistas con layouts. Permite pasar datos a
templates de forma segura y organizada, reutilizando layouts generales.
*/

<?php

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.view.php';
        $layoutPath = __DIR__ . '/../views/layouts/' . $layout . '.layout.php';

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
