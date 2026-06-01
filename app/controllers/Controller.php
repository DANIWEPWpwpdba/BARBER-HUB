<?php
/**
 * Barber Hub - Base Controller
 * Proporciona métodos comunes para cargar modelos y vistas.
 */

class Controller {

    public function __construct() {
        // Validar que la sesión activa siga existiendo en la BD real
        if (isset($_SESSION['user_id'])) {
            require_once '../app/models/Model.php';
            $db = new Model();
            $userExists = $db->query("SELECT id FROM usuarios WHERE id = ?", [$_SESSION['user_id']])->fetch();
            if (!$userExists) {
                session_destroy();
                session_start(); // Iniciar una nueva sesión limpia
                header('Location: ' . BASE_URL . '/auth/login?error=' . urlencode('Tu sesión expiró o la cuenta fue eliminada tras la actualización del sistema.'));
                exit();
            }
        }
    }

    /**
     * Carga un modelo
     * @param string $model Nombre del modelo
     * @return object Instancia del modelo
     */
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Carga una vista y le pasa datos
     * @param string $view Ruta de la vista (ej. 'home/index')
     * @param array $data Datos a extraer en la vista
     */
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            // Extrae el array asociativo en variables locales
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            die("La vista {$view} no existe.");
        }
    }
}
