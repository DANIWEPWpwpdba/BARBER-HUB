<?php
// Garantizar que BASE_URL está disponible
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config/app.php';

class AuthController extends Controller {
    
    public function index() {
        header('Location: ' . BASE_URL . '/auth/login');
        exit();
    }

    public function login() {
        $data = [
            'titulo' => 'Iniciar Sesión | Barber Hub',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = trim($_POST['correo']);
            $password = trim($_POST['password']);
            
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($correo);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['estado'] === 'Activo' || ($user['estado'] === 'Pendiente' && $user['rol_id'] == 6)) {
                    // Iniciar sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['rol_id'] = $user['rol_id'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['barberia_id'] = $user['barberia_id'];
                    
                    if ($user['rol_id'] == 6) {
                        header('Location: ' . BASE_URL . '/perfil');
                    } else {
                        header('Location: ' . BASE_URL . '/dashboard');
                    }
                    exit();
                } else if ($user['estado'] === 'Pendiente') {
                    $data['error'] = 'Tu cuenta de empleado está en revisión. Un administrador la aprobará pronto.';
                } else {
                    $data['error'] = 'Tu cuenta no está activa. Contacta a soporte.';
                }
            } else {
                $data['error'] = 'Correo o contraseña incorrectos.';
            }
        }

        $this->view('auth/login', $data);
    }
    
    public function register() {
        $data = [
            'titulo' => 'Registro de Cliente | Barber Hub',
            'error' => '',
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            
            if (empty($nombre) || empty($correo) || empty($password)) {
                $data['error'] = 'Por favor, completa todos los campos obligatorios.';
            } else if ($password !== $confirm) {
                $data['error'] = 'Las contraseñas no coinciden.';
            } else if (strlen($password) < 6) {
                $data['error'] = 'La contraseña debe tener al menos 6 caracteres.';
            } else {
                $userModel = $this->model('User');
                $result = $userModel->createClient($nombre, $correo, $telefono, $password);
                
                if ($result['success']) {
                    $data['success'] = '¡Registro exitoso! Tu cuenta ha sido creada y está en estado Pendiente. Un administrador la validará pronto.';
                } else {
                    $data['error'] = $result['error'];
                }
            }
        }

        $this->view('auth/register', $data);
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/auth/login');
        exit();
    }
}
