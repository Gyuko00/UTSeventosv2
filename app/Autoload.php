<?php

// Carga los archivos base del sistema: configuración, rutas, core, módulos y dependencias

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/router.php';
require_once __DIR__ . '/core/Render.php';
require_once __DIR__ . '/core/Database.php';

// Carga controladores por módulo (modular)
require_once __DIR__ . '/modules/auth/controllers/AuthController.php';
// Agrega aquí más controladores según los módulos

require_once __DIR__ . '/../vendor/autoload.php'; // Composer
?>