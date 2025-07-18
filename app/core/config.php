<?php
/**
 * Configuración general de la aplicación.
 *
 * Este archivo define las constantes globales y parámetros de entorno
 * necesarios para el funcionamiento del sistema de gestión de eventos.
 * Incluye:
 * - URL base dinámica (según HTTP/HTTPS y ruta de despliegue)
 * - Nombre y entorno de la aplicación
 * - Configuración de zona horaria (Colombia)
 * - Parámetros básicos de seguridad
 */
 
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$folderPath = dirname($_SERVER['SCRIPT_NAME']);

define('URL_PATH', $protocol . $host . $folderPath);
define('APP_NAME', 'UTSeventos');
define('APP_ENV', 'development'); 
define('SECURE', true);

date_default_timezone_set('America/Bogota');
