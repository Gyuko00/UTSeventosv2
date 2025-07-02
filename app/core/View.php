<?php

/*
View.php

Clase para renderizar vistas organizadas por módulos con layouts generales.
Permite utilizar rutas tipo 'modulo/vista' y pasar datos al layout principal.
*/

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        // Soporta formato 'modulo/vista'
        $viewParts = explode('/', $view);
        if (count($viewParts) !== 2) {
            die("Error: Formato de vista inválido. Usa 'modulo/vista'");
        }

        [$module, $viewName] = $viewParts;

        // Rutas absolutas correctas usando DIRECTORY_SEPARATOR
        $viewPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $viewName . '.view.php';

        $layoutPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.layout.php';

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
