<?php

// Punto de entrada principal del sistema

require_once __DIR__ . '/app/autoload.php';

$router = new Router();
$router->run();
?>