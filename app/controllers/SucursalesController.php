<?php
class SucursalesController extends Controller {
    public function index() {
        if (!defined('BASE_URL')) require_once '../config/app.php';

        $barberias = [];
        $servicios = [];
        $footer_cfg = [];

        try {
            $db = $this->model('Model');
            
            // Traer todas las barberías con su calificación promedio
            $sql_barberias = "SELECT b.*, 
                                (SELECT COALESCE(AVG(r.calificacion), 0) FROM resenas r WHERE r.barberia_id = b.id) as rating 
                              FROM barberias b 
                              WHERE b.estado = 'Activa' 
                              ORDER BY rating DESC, b.nombre_comercial ASC";
            $barberias = $db->query($sql_barberias)->fetchAll();
            
            // Para poder filtrar por servicio, traemos la lista de servicios únicos
            $sql_servicios = "SELECT DISTINCT nombre FROM servicios WHERE estado = 'Activo' ORDER BY nombre ASC";
            $servicios = $db->query($sql_servicios)->fetchAll();
            
            // Agregar al arreglo de barberías, la lista de servicios que ofrecen como string separado por comas
            // Para que el filtro JS funcione fácilmente
            foreach($barberias as &$b) {
                $b['servicios_nombres'] = '';
                $srvs = $db->query("SELECT nombre FROM servicios WHERE barberia_id = ? AND estado = 'Activo'", [$b['id']])->fetchAll();
                $arr = array_column($srvs, 'nombre');
                $b['servicios_nombres'] = strtolower(implode(', ', $arr));
            }

            $footerModel = $this->model('FooterConfig');
            $footer_cfg = $footerModel->getAll();
        } catch (Exception $e) {
            // Error
        }

        $data = [
            'titulo'     => APP_NAME . ' | Todas las Sucursales',
            'barberias'  => $barberias,
            'servicios'  => $servicios,
            'footer_cfg' => $footer_cfg,
        ];
        
        $this->view('sucursales/index', $data);
    }
}
