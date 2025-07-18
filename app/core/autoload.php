<?php
/**
 * Autoload: carga automática de clases del sistema de eventos universitarios.
 * Busca las clases en core, models, services y controllers de cada módulo.
 */

require_once __DIR__ . '/config.php';

spl_autoload_register(function($class) {
    $baseDir = dirname(__DIR__); 
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir)
    );
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getFilename() === $class . '.php') {
            require_once $file->getPathname();
            return;
        }
    }
});

if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}
