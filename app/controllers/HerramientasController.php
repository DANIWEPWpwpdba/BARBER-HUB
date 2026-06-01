<?php
class HerramientasController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] > 2) { // Solo SuperAdmin(1) y Dev(2)
            die("Acceso denegado. Solo Desarrolladores y SuperAdmins pueden hacer backups.");
        }
    }

    public function index() {
        $data = [
            'titulo' => 'Herramientas del Sistema | Barber Hub',
            'seccion' => 'herramientas',
            'vista_hija' => '../app/views/dashboard/seguridad/herramientas.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function backup_db() {
        // Ejecutar mysqldump (Requiere que mysqldump esté en las variables de entorno, que sí está en XAMPP)
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'barber_hub';
        
        $backup_file = 'backup_barberhub_' . date("Y-m-d-H-i-s") . '.sql';
        $backup_path = __DIR__ . '/../../public/uploads/' . $backup_file;
        
        // Comando mysqldump para XAMPP
        $command = "C:\\xampp\\mysql\\bin\\mysqldump --user={$db_user} --host={$db_host} {$db_name} > {$backup_path}";
        
        // Ejecutamos el comando
        exec($command, $output, $return_var);
        
        if ($return_var === 0 && file_exists($backup_path)) {
            // Forzar descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($backup_path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_path));
            flush(); // Flush system output buffer
            readfile($backup_path);
            
            // Eliminar el archivo del servidor después de descargar por seguridad
            unlink($backup_path);
            
            // Auditoría
            require_once '../app/models/Auditoria.php';
            $aud = new Auditoria();
            $aud->registrarAccion($_SESSION['user_id'], "Descargó un backup de la Base de Datos.");
            exit;
        } else {
            die("Error al generar el respaldo de la base de datos. Asegúrate de que mysqldump esté disponible.");
        }
    }
}
