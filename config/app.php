<?php
/**
 * Barber Hub - Configuración Global de la Aplicación
 * AUTO-DETECTA la URL base para que funcione en cualquier ruta de XAMPP.
 */

// Detecta automáticamente el protocolo y host
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'];

// Detecta la ruta base desde la carpeta "public" hacia arriba
// Si está en /barber_hub/public/index.php → base será /barber_hub/public
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$scriptDir = rtrim($scriptDir, '/');

define('BASE_URL', $protocol . '://' . $host . $scriptDir);
define('ASSETS_URL', BASE_URL . '/assets');
define('APP_NAME', 'Barber Hub');
define('APP_VERSION', '2.1');
