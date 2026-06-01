<?php
class PerfilController extends Controller {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        require_once '../app/models/Cliente.php';
        $clienteModel = new Cliente();
        $cliente_info = $clienteModel->getByUsuarioId($_SESSION['user_id']);

        if (!$cliente_info) {
            session_destroy();
            header('Location: ' . BASE_URL . '/auth/login?error=' . urlencode('Tu sesión expiró o la cuenta fue eliminada. Por favor, inicia sesión de nuevo.'));
            exit();
        }

        // Obtener citas pasadas (para reseñas) y futuras
        $db = $this->model('Model');
        $citas_futuras = $db->query("SELECT c.*, s.nombre as servicio, b.nombre_comercial as barberia, u.nombre as barbero 
            FROM citas c 
            JOIN servicios s ON c.servicio_id = s.id 
            JOIN barberias b ON c.barberia_id = b.id 
            JOIN barberos bar ON c.barbero_id = bar.id
            JOIN usuarios u ON bar.usuario_id = u.id
            WHERE c.cliente_id = :cid AND c.estado IN ('Pendiente', 'Confirmada', 'Reagendada')
            ORDER BY c.fecha ASC, c.hora ASC", [':cid' => $cliente_info['id']])->fetchAll();

        $citas_pasadas = $db->query("SELECT c.*, s.nombre as servicio, u.nombre as barbero, r.id as resena_id 
            FROM citas c 
            JOIN servicios s ON c.servicio_id = s.id 
            JOIN barberos bar ON c.barbero_id = bar.id
            JOIN usuarios u ON bar.usuario_id = u.id
            LEFT JOIN resenas r ON c.id = r.cita_id
            WHERE c.cliente_id = :cid AND c.estado = 'Finalizada'
            ORDER BY c.fecha DESC", [':cid' => $cliente_info['id']])->fetchAll();

        $data = [
            'titulo' => 'Mi Perfil | Barber Hub',
            'cliente' => $cliente_info,
            'citas_futuras' => $citas_futuras,
            'citas_pasadas' => $citas_pasadas
        ];
        
        $this->view('cliente/perfil', $data);
    }

    public function guardar_resena() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cita_id'])) {
            require_once '../app/models/Cliente.php';
            $clienteModel = new Cliente();
            $cliente = $clienteModel->getByUsuarioId($_SESSION['user_id']);
            
            require_once '../app/models/Cita.php';
            $citaModel = new Cita();
            $cita = $citaModel->getById($_POST['cita_id']);
            
            if ($cita && $cita['cliente_id'] == $cliente['id'] && $cita['estado'] == 'Finalizada') {
                require_once '../app/models/Resena.php';
                $resenaModel = new Resena();
                $resenaModel->crear(
                    $cita['id'], 
                    $cliente['id'], 
                    $cita['barbero_id'], 
                    $cita['barberia_id'], 
                    $_POST['calificacion'], 
                    $_POST['comentario']
                );
                
                require_once '../app/models/Auditoria.php';
                $aud = new Auditoria();
                $aud->registrarAccion($_SESSION['user_id'], "Dejó una reseña de {$_POST['calificacion']} estrellas para la cita #{$cita['codigo_unico']}");

                header('Location: ' . BASE_URL . '/perfil?msg=resena_guardada');
                exit();
            }
        }
        header('Location: ' . BASE_URL . '/perfil?error=accion_invalida');
        exit();
    }
    
    public function subir_foto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
            $file = $_FILES['foto'];
            
            if ($file['error'] !== UPLOAD_ERR_OK) {
                header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('Error en la subida: código ' . $file['error']));
                exit();
            }

            // Validar que realmente sea una imagen
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (strpos($mime, 'image/') !== 0) {
                header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('El archivo no es una imagen válida.'));
                exit();
            }

            if ($file['size'] > 5000000) { // 5MB
                header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('El archivo es muy pesado (Máximo 5MB).'));
                exit();
            }
            
            $upload_dir = __DIR__ . '/../../public/uploads/perfiles/';
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('Error interno: No se pudo crear el directorio de subidas.'));
                    exit();
                }
            }
            
            $filename = 'perfil_' . $_SESSION['user_id'] . '_' . time();
            
            // Si la extensión GD no está activa, simplemente guardamos el archivo original
            if (!extension_loaded('gd') || !function_exists('imagecreatefromjpeg')) {
                $destination = $upload_dir . $filename . '.' . str_replace('jpeg', 'jpg', str_replace('image/', '', $mime));
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $url = BASE_URL . '/uploads/perfiles/' . basename($destination);
                    $userModel = $this->model('User');
                    $userModel->query("UPDATE usuarios SET fotografia = :foto WHERE id = :id", [':foto' => $url, ':id' => $_SESSION['user_id']]);
                    header('Location: ' . BASE_URL . '/perfil?msg=foto_actualizada');
                    exit();
                } else {
                    header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('No se pudo guardar la imagen (Sin GD).'));
                    exit();
                }
            }

            $destination = $upload_dir . $filename . '.webp';
            
            // Crear recurso de imagen según el tipo mime
            $image = null;
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = @imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($file['tmp_name']);
                    // Mantener transparencia
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                    break;
                case 'image/gif':
                    $image = @imagecreatefromgif($file['tmp_name']);
                    break;
                case 'image/webp':
                    $image = @imagecreatefromwebp($file['tmp_name']);
                    break;
                default:
                    // Intentar cargar a pesar del mime
                    $image = @imagecreatefromstring(file_get_contents($file['tmp_name']));
                    break;
            }

            if (!$image) {
                header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('No se pudo procesar la imagen. Intenta con otro archivo.'));
                exit();
            }

            // Convertir a webp y guardar (Calidad 80)
            if (imagewebp($image, $destination, 80)) {
                imagedestroy($image);
                
                $url = BASE_URL . '/uploads/perfiles/' . basename($destination);
                
                // Actualizar BD
                $userModel = $this->model('User');
                $userModel->query("UPDATE usuarios SET fotografia = :foto WHERE id = :id", [
                    ':foto' => $url,
                    ':id' => $_SESSION['user_id']
                ]);
                
                header('Location: ' . BASE_URL . '/perfil?msg=foto_actualizada');
                exit();
            } else {
                imagedestroy($image);
                header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('No se pudo guardar la imagen WebP en el servidor.'));
                exit();
            }
        }
        header('Location: ' . BASE_URL . '/perfil?error=' . urlencode('No se recibió ningún archivo.'));
        exit();
    }
}
