<?php
class AuditoriaController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] > 3) { // Solo SuperAdmin(1), Dev(2), Propietario(3)
            die("Acceso denegado a Auditoría.");
        }
    }

    public function index() {
        require_once '../app/models/Auditoria.php';
        $auditoriaModel = new Auditoria();
        
        $historial = $auditoriaModel->getHistorialGlobal(200); // Traer los últimos 200 registros

        $data = [
            'titulo' => 'Auditoría del Sistema | Barber Hub',
            'seccion' => 'seguridad',
            'vista_hija' => '../app/views/dashboard/seguridad/auditoria.php',
            'historial' => $historial
        ];

        $this->view('dashboard/layout', $data);
    }
}
