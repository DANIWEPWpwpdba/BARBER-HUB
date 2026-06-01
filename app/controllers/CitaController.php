<?php
class CitaController extends Controller {

    public function reservar($slug = '') {
        if (!isset($_SESSION['user_id'])) {
            // Require login
            header('Location: ' . BASE_URL . '/auth/login?redirect=' . urlencode('/cita/reservar/' . $slug));
            exit();
        }
        
        // Ensure user is an active client
        if ($_SESSION['rol_id'] != 6) {
            die("Solo los clientes pueden reservar citas desde aquí.");
        }

        $barbModel = $this->model('Barberia');
        $todas = $barbModel->getActivas();
        
        $barberia_actual = null;
        foreach ($todas as $b) {
            $b_slug = strtolower(str_replace(' ', '-', $b['nombre_comercial']));
            if ($b_slug === strtolower($slug)) {
                $barberia_actual = $b;
                break;
            }
        }

        if (!$barberia_actual) {
            die("Sucursal no encontrada.");
        }

        $servModel = $this->model('Servicio');
        $barberoModel = $this->model('Barbero');

        $data = [
            'titulo' => 'Reservar Cita en ' . $barberia_actual['nombre_comercial'],
            'barberia' => $barberia_actual,
            'servicios' => $servModel->getByBarberia($barberia_actual['id']),
            'barberos' => $barberoModel->getAllByBarberia($barberia_actual['id'])
        ];

        $this->view('citas/reservar', $data);
    }

    public function api_disponibilidad() {
        if (!isset($_GET['barbero_id']) || !isset($_GET['fecha']) || !isset($_GET['servicio_id'])) {
            echo json_encode([]);
            exit();
        }

        $b_id = (int)$_GET['barbero_id'];
        $fecha = $_GET['fecha'];
        $s_id = (int)$_GET['servicio_id'];

        $servModel = $this->model('Servicio');
        $servicio = $servModel->getById($s_id);
        if (!$servicio) { echo json_encode([]); exit(); }

        $citaModel = $this->model('Cita');
        $horarios = $citaModel->calcularHorariosDisponibles($b_id, $fecha, $servicio['duracion_minutos']);

        header('Content-Type: application/json');
        echo json_encode($horarios);
        exit();
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            // Find client ID for this user ID
            $userModel = $this->model('User');
            $stmt = $userModel->query("SELECT id FROM clientes WHERE usuario_id = :u_id", [':u_id' => $_SESSION['user_id']]);
            $cliente = $stmt->fetch();
            
            if (!$cliente) {
                die("Perfil de cliente no válido.");
            }

            $servModel = $this->model('Servicio');
            $servicio = $servModel->getById($_POST['servicio_id']);

            $datos = [
                'barberia_id' => $_POST['barberia_id'],
                'cliente_id' => $cliente['id'],
                'barbero_id' => $_POST['barbero_id'],
                'servicio_id' => $_POST['servicio_id'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['hora'],
                'duracion_minutos' => $servicio['duracion_minutos']
            ];

            $citaModel = $this->model('Cita');
            $codigo = $citaModel->crear($datos);

            header('Location: ' . BASE_URL . '/cita/exito/' . $codigo);
            exit();
        }
    }

    public function exito($codigo = '') {
        $data = ['titulo' => 'Cita Confirmada', 'codigo' => $codigo];
        $this->view('citas/exito', $data);
    }
}
