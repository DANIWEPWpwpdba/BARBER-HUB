<?php
class DevsController extends Controller {

    // ── Solo dev1 y dev2 pueden acceder al CRUD ──
    private function soloMaestros() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        // IDs de Daniel y David (primeros 2 usuarios creados por seed)
        $permitidos = [1, 2];
        if (!in_array($_SESSION['user_id'], $permitidos)) {
            http_response_code(403);
            die('<h2 style="font-family:sans-serif;color:#fff;background:#111;padding:40px;text-align:center;">⛔ Acceso denegado. Solo los desarrolladores maestros pueden gestionar esta sección.</h2>');
        }
    }

    // ── Página pública de créditos ──
    public function index() {
        if (!defined('BASE_URL')) require_once '../config/app.php';

        $devs = [];
        $footer_cfg = [];
        try {
            $devModel    = $this->model('Desarrollador');
            $footerModel = $this->model('FooterConfig');
            $devs        = $devModel->getActivos();
            $footer_cfg  = $footerModel->getAll();
        } catch (Exception $e) {
            // BD no disponible - se usan datos demo en la vista
        }

        $data = [
            'titulo'     => 'Equipo de Desarrollo | ' . APP_NAME,
            'devs'       => $devs,
            'footer_cfg' => $footer_cfg,
        ];
        $this->view('devs/index', $data);
    }

    // ── Admin: listar todos (activos e inactivos) ──
    public function admin() {
        $this->soloMaestros();
        $devModel = $this->model('Desarrollador');
        $data = [
            'titulo' => 'Gestión de Desarrolladores | ' . APP_NAME,
            'devs'   => $devModel->getAll(),
        ];
        $this->view('devs/admin', $data);
    }

    // ── Admin: formulario nuevo ──
    public function crear() {
        $this->soloMaestros();
        $data = ['titulo' => 'Agregar Desarrollador', 'dev' => null, 'error' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $devModel = $this->model('Desarrollador');
            $devModel->crear($_POST, $_SESSION['user_id']);
            header('Location: ' . BASE_URL . '/devs/admin');
            exit();
        }
        $this->view('devs/form', $data);
    }

    // ── Admin: Credenciales SuperAdmin ──
    public function credenciales() {
        $this->soloMaestros();
        $userModel = $this->model('User');
        $usuario = $userModel->query("SELECT * FROM usuarios WHERE id = ?", [$_SESSION['user_id']])->fetch();
        
        $data = [
            'titulo'  => 'Mis Credenciales | ' . APP_NAME,
            'usuario' => $usuario,
            'error'   => $_GET['error'] ?? '',
            'success' => $_GET['success'] ?? ''
        ];
        $this->view('devs/credenciales', $data);
    }

    public function actualizar_credenciales() {
        $this->soloMaestros();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['correo']);
            $password = $_POST['password'];
            
            if (empty($correo)) {
                header('Location: ' . BASE_URL . '/devs/credenciales?error=' . urlencode('El correo es obligatorio.'));
                exit();
            }

            $userModel = $this->model('User');
            
            // Si intenta cambiar a un correo que ya existe (y no es el suyo)
            $existente = $userModel->findByEmail($correo);
            if ($existente && $existente['id'] != $_SESSION['user_id']) {
                header('Location: ' . BASE_URL . '/devs/credenciales?error=' . urlencode('Ese correo ya está en uso.'));
                exit();
            }

            if (!empty($password)) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $userModel->query("UPDATE usuarios SET correo = ?, password = ? WHERE id = ?", [$correo, $hash, $_SESSION['user_id']]);
            } else {
                $userModel->query("UPDATE usuarios SET correo = ? WHERE id = ?", [$correo, $_SESSION['user_id']]);
            }

            header('Location: ' . BASE_URL . '/devs/credenciales?success=' . urlencode('Tus credenciales han sido actualizadas.'));
            exit();
        }
        header('Location: ' . BASE_URL . '/devs/admin');
        exit();
    }

    // ── Admin: editar ──
    public function editar($id = null) {
        $this->soloMaestros();
        $devModel = $this->model('Desarrollador');
        $dev = $devModel->getById((int)$id);
        $data = ['titulo' => 'Editar Desarrollador', 'dev' => $dev, 'error' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $devModel->actualizar((int)$id, $_POST);
            header('Location: ' . BASE_URL . '/devs/admin');
            exit();
        }
        $this->view('devs/form', $data);
    }

    // ── Admin: cambiar estado (activar/suspender) ──
    public function toggleEstado($id = null) {
        $this->soloMaestros();
        $devModel = $this->model('Desarrollador');
        $devModel->toggleEstado((int)$id);
        header('Location: ' . BASE_URL . '/devs/admin');
        exit();
    }

    // ── Admin: editar footer ──
    public function footer() {
        $this->soloMaestros();
        $footerModel = $this->model('FooterConfig');
        $data = [
            'titulo' => 'Configurar Footer | ' . APP_NAME,
            'config' => $footerModel->getAll(),
            'guardado' => false,
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['config'] as $clave => $valor) {
                $footerModel->actualizar($clave, $valor);
            }
            $data['guardado'] = true;
            $data['config']   = $footerModel->getAll();
        }
        $this->view('devs/footer', $data);
    }
}
