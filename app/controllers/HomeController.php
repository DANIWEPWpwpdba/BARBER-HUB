<?php
class HomeController extends Controller {
    public function index() {
        if (!defined('BASE_URL')) require_once '../config/app.php';

        // Intentar cargar barberias y footer desde BD
        // Si falla (BD no conectada), se usan los datos demo dentro de la vista
        $top_barberias = [];
        $top_barberos = [];
        $footer_cfg = [];
        
        try {
            $db = $this->model('Model');
            
            // Top 5 Barberías por calificación promedio de reseñas
            $sql_barberias = "SELECT b.*, 
                                (SELECT COALESCE(AVG(r.calificacion), 0) FROM resenas r WHERE r.barberia_id = b.id) as rating 
                              FROM barberias b 
                              WHERE b.estado = 'Activa' 
                              ORDER BY rating DESC 
                              LIMIT 5";
            $top_barberias = $db->query($sql_barberias)->fetchAll();

            // Top 10 Barberos
            $sql_barberos = "SELECT u.nombre, u.fotografia, u.correo, b.anios_experiencia, b.biografia, barb.nombre_comercial as sucursal,
                                (SELECT COALESCE(AVG(r.calificacion), 0) FROM resenas r WHERE r.barbero_id = b.id) as rating 
                             FROM barberos b 
                             JOIN usuarios u ON b.usuario_id = u.id 
                             JOIN barberias barb ON b.barberia_id = barb.id
                             WHERE b.estado = 'Activo' 
                             ORDER BY rating DESC, b.anios_experiencia DESC 
                             LIMIT 10";
            $top_barberos = $db->query($sql_barberos)->fetchAll();

            $footerModel = $this->model('FooterConfig');
            $footer_cfg = $footerModel->getAll();
        } catch (Exception $e) {
            // BD no disponible
        }

        $data = [
            'titulo'        => APP_NAME . ' | Nuestras Barberías',
            'top_barberias' => $top_barberias,
            'top_barberos'  => $top_barberos,
            'footer_cfg'    => $footer_cfg,
        ];
        $this->view('home/index', $data);
    }
}
