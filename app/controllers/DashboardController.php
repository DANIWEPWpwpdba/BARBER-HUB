<?php
class DashboardController extends Controller {
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
    }

    public function index() {
        if ($_SESSION['rol_id'] == 6) {
            header('Location: ' . BASE_URL . '/perfil');
            exit();
        }
        
        $data = [
            'titulo' => 'Panel de Administración | Barber Hub',
            'seccion' => 'inicio',
            'vista_hija' => '../app/views/dashboard/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function clientes_pendientes() {
        // Solo roles 1 (Super Admin), 2 (Dev), 3 (Propietario), 4 (Moderador) deberían aprobar
        // Asumiendo roles 1,2,3,4 tienen acceso a esto.
        if ($_SESSION['rol_id'] > 4) {
            http_response_code(403);
            die("No tienes permisos para ver esta sección.");
        }

        $userModel = $this->model('User');
        // Obtener usuarios pendientes. Añadiremos un método rápido directo aquí o en el modelo
        $stmt = $userModel->query("SELECT * FROM usuarios WHERE estado = 'Pendiente' AND rol_id = 6 ORDER BY fecha_registro DESC");
        $pendientes = $stmt->fetchAll();

        $data = [
            'titulo' => 'Aprobación de Clientes | Barber Hub',
            'seccion' => 'pendientes',
            'pendientes' => $pendientes,
            'vista_hija' => '../app/views/dashboard/pendientes.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function aprobar_usuario($id) {
        if ($_SESSION['rol_id'] > 4) exit('Sin permisos');
        
        $userModel = $this->model('User');
        $userModel->query("UPDATE usuarios SET estado = 'Activo' WHERE id = :id", [':id' => $id]);
        
        // Registrar en auditoría si se desea
        header('Location: ' . BASE_URL . '/dashboard/clientes_pendientes?msg=aprobado');
        exit();
    }

    public function cambiar_password($id) {
        if ($_SESSION['rol_id'] > 4) exit('Sin permisos');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva = $_POST['nueva_password'] ?? '';
            if (strlen($nueva) >= 6) {
                $hashed = password_hash($nueva, PASSWORD_BCRYPT);
                $userModel = $this->model('User');
                $userModel->query("UPDATE usuarios SET password = :pwd WHERE id = :id", [':pwd' => $hashed, ':id' => $id]);
                header('Location: ' . BASE_URL . '/dashboard/clientes_pendientes?msg=pwd_changed');
                exit();
            }
        }
        header('Location: ' . BASE_URL . '/dashboard/clientes_pendientes?error=pwd_short');
        exit();
    }

    // ─────────────────────────────────────────
    // SUCURSALES / BARBERÍAS
    // ─────────────────────────────────────────
    public function sucursales() {
        $barbModel = $this->model('Barberia');
        
        // Listar las barberías directamente como si fueran sucursales
        $sucursales = $barbModel->getActivas();

        $data = [
            'titulo' => 'Gestión de Sucursales | Barber Hub',
            'seccion' => 'sucursales',
            'sucursales' => $sucursales,
            'vista_hija' => '../app/views/dashboard/sucursales/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function crear_sucursal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $barbModel = $this->model('Barberia');
            $barbModel->crearBarberia($_POST);
            header('Location: ' . BASE_URL . '/dashboard/sucursales?msg=creada');
            exit();
        }
        header('Location: ' . BASE_URL . '/dashboard/sucursales');
        exit();
    }

    // ─────────────────────────────────────────
    // BARBEROS
    // ─────────────────────────────────────────
    public function barberos($action = '') {
        if ($action === 'nuevo') {
            $barbModel = $this->model('Barberia');
            $data = [
                'titulo' => 'Añadir Personal | Barber Hub',
                'seccion' => 'barberos',
                'barberias' => $barbModel->getActivas(),
                'vista_hija' => '../app/views/dashboard/barberos/form.php'
            ];
            $this->view('dashboard/layout', $data);
            return;
        }

        $barberoModel = $this->model('Barbero');
        $barberos = $barberoModel->getAll();

        $data = [
            'titulo' => 'Gestión de Barberos | Barber Hub',
            'seccion' => 'barberos',
            'barberos' => $barberos,
            'vista_hija' => '../app/views/dashboard/barberos/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function crear_barbero() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos_usuario = [
                'nombre' => $_POST['nombre'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'password' => 'Hub2026' // Contraseña temporal por defecto
            ];
            
            $datos_barbero = [
                'barberia_id' => $_POST['barberia_id'],
                'sucursal_id' => null, // Ya no se usa jerarquía
                'biografia' => $_POST['biografia'],
                'anios_experiencia' => $_POST['anios_experiencia']
            ];

            $barberoModel = $this->model('Barbero');
            $res = $barberoModel->crearBarbero($datos_usuario, $datos_barbero);

            if ($res['success']) {
                header('Location: ' . BASE_URL . '/dashboard/barberos?msg=creado');
                exit();
            } else {
                header('Location: ' . BASE_URL . '/dashboard/barberos/nuevo?error=' . urlencode($res['error']));
                exit();
            }
        }

        // Vista de formulario
        $barbModel = $this->model('Barberia');
        $data = [
            'titulo' => 'Añadir Personal | Barber Hub',
            'seccion' => 'barberos',
            'barberias' => $barbModel->getActivas(),
            'vista_hija' => '../app/views/dashboard/barberos/form.php'
        ];
        $this->view('dashboard/layout', $data);
    }
    // ─────────────────────────────────────────
    // CLIENTES (GENERAL)
    // ─────────────────────────────────────────
    public function clientes() {
        if ($_SESSION['rol_id'] > 3) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
        
        $sql = "SELECT c.*, u.nombre, u.correo, u.telefono, u.estado 
                FROM clientes c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE u.rol_id = 6 
                ORDER BY u.nombre ASC";
        $clientes = $this->model('User')->query($sql)->fetchAll();

        $data = [
            'titulo' => 'Gestión de Clientes | Barber Hub',
            'seccion' => 'clientes',
            'clientes' => $clientes,
            'vista_hija' => '../app/views/dashboard/clientes/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function editar_cliente($id = null) {
        if ($_SESSION['rol_id'] > 3) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
        
        $userModel = $this->model('User');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $estado = $_POST['estado'];
            
            $sql = "UPDATE usuarios SET nombre = :n, telefono = :t, estado = :e WHERE id = :id";
            $userModel->query($sql, [':n'=>$nombre, ':t'=>$telefono, ':e'=>$estado, ':id'=>$id]);
            
            if (!empty($_POST['password'])) {
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userModel->query("UPDATE usuarios SET password = :p WHERE id = :id", [':p'=>$hash, ':id'=>$id]);
            }
            
            header('Location: ' . BASE_URL . '/dashboard/clientes?msg=actualizado');
            exit();
        }
        
        $sql = "SELECT c.*, u.id as u_id, u.nombre, u.correo, u.telefono, u.estado 
                FROM clientes c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.id = :id";
        $stmt = $userModel->query($sql, [':id' => $id]);
        $cliente = $stmt->fetch();
        
        if (!$cliente) {
            header('Location: ' . BASE_URL . '/dashboard/clientes');
            exit();
        }

        $data = [
            'titulo' => 'Editar Cliente | Barber Hub',
            'seccion' => 'clientes',
            'cliente' => $cliente,
            'vista_hija' => '../app/views/dashboard/clientes/form.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    // ─────────────────────────────────────────
    // SERVICIOS
    // ─────────────────────────────────────────
    public function servicios() {
        $servicioModel = $this->model('Servicio');
        $barbModel = $this->model('Barberia');
        
        $data = [
            'titulo' => 'Catálogo de Servicios | Barber Hub',
            'seccion' => 'servicios',
            'servicios' => $servicioModel->getAll(),
            'barberias' => $barbModel->getActivas(),
            'vista_hija' => '../app/views/dashboard/servicios/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }

    public function crear_servicio() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicioModel = $this->model('Servicio');
            $servicioModel->crear($_POST);
            header('Location: ' . BASE_URL . '/dashboard/servicios?msg=creado');
            exit();
        }
        header('Location: ' . BASE_URL . '/dashboard/servicios');
        exit();
    }

    public function toggle_servicio($id) {
        $servicioModel = $this->model('Servicio');
        $servicioModel->toggleEstado($id);
        header('Location: ' . BASE_URL . '/dashboard/servicios?msg=estado_cambiado');
        exit();
    }

    // ─────────────────────────────────────────
    // AGENDA
    // ─────────────────────────────────────────
    public function agenda() {
        $citaModel = $this->model('Cita');
        $barbModel = $this->model('Barberia');
        
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        
        $citas = [];
        $barberias = [];
        
        if ($_SESSION['rol_id'] == 5) { // Barbero
            // Obtener su ID de barbero
            $stmt = $this->model('User')->query("SELECT id, barberia_id FROM barberos WHERE usuario_id = :u", [':u' => $_SESSION['user_id']]);
            $barbero = $stmt->fetch();
            if ($barbero) {
                $citas = $citaModel->getAgendaBarbero($barbero['id'], $fecha);
            }
        } else { // Admin o Superior
            $barberias = $barbModel->getActivas();
            $b_id = $_GET['barberia_id'] ?? ($barberias[0]['id'] ?? 0);
            if ($b_id > 0) {
                $citas = $citaModel->getAgendaGeneral($b_id, $fecha);
            }
        }

        $data = [
            'titulo' => 'Agenda Diaria | Barber Hub',
            'seccion' => 'agenda',
            'citas' => $citas,
            'fecha_actual' => $fecha,
            'barberias' => $barberias,
            'vista_hija' => '../app/views/dashboard/agenda/index.php'
        ];
        $this->view('dashboard/layout', $data);
    }
    
    public function estado_cita($id, $estado) {
        $validos = ['Confirmada', 'Finalizada', 'Cancelada', 'No asistio'];
        if (in_array($estado, $validos)) {
            $this->model('Cita')->actualizarEstado($id, $estado);
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '/dashboard/agenda'));
        exit();
    }
}
