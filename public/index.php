<?php
/**
 * Barber Hub - Front Controller
 * Punto de entrada único para la aplicación MVC.
 */

session_start();

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ── Cargar Configuración Global (BASE_URL, ASSETS_URL, etc.) ──
require_once '../config/app.php';

// ── Cargar Controlador Base ──
require_once '../app/controllers/Controller.php';

// ── Enrutador MVC ──
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . 'Controller';
$controllerFile = '../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName;

    $methodName = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';

    if (method_exists($controller, $methodName)) {
        unset($url[0], $url[1]);
        $params = $url ? array_values($url) : [];
        call_user_func_array([$controller, $methodName], $params);
    } else {
        // Fallback: Si el método no existe, asumimos que es un parámetro para el método 'index'
        if (method_exists($controller, 'index')) {
            unset($url[0]);
            $params = $url ? array_values($url) : [];
            call_user_func_array([$controller, 'index'], $params);
        } else {
            http_response_code(404);
            die("<h2>Error 404</h2><p>El método <b>{$methodName}</b> no existe en <b>{$controllerName}</b>.</p>");
        }
    }
} else {
    http_response_code(404);
    die("<h2>Error 404</h2><p>El controlador <b>{$controllerName}</b> no existe.</p>");
}
