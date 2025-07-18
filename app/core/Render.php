<?php
/**
 * Render: motor de renderizado de vistas con soporte de layouts y datos dinámicos.
 * Permite definir layouts base por módulo y renderiza la vista dentro del layout seleccionado.
 */

class Render
{
    public static function render(string $view, array $data = [], string $site = 'main'): void
    {
        $viewParts = explode('/', $view);

        if (count($viewParts) !== 2) {
            throw new Exception("Formato de vista inválido. Usa 'modulo/vista'");
        }

        [$module, $viewName] = $viewParts;

        $basePath = __DIR__ . '/../modules';

        $viewPath = $basePath . "/{$module}/{$viewName}.view.php";

        $sitePath = $basePath . "/{$module}/layouts/{$site}.site.php";

        if (!file_exists($viewPath)) {
            throw new Exception("Vista no encontrada: " . $viewPath);
        }

        if (!file_exists($sitePath)) {
            throw new Exception("Layout no encontrado: " . $sitePath);
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $sitePath;
    }
}
