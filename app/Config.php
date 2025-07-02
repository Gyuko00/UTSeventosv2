<?php

// Configura el protocolo y la URL base

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$folderPath = dirname($_SERVER['SCRIPT_NAME']);
define('URL_PATH', $protocol . $host . $folderPath);
?>
