<?php
class FinanzasController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] > 5) { // SuperAdmin(1) hasta Barbero(5)
            die("Acceso denegado.");
        }
    }

    public function index() {
        if ($_SESSION['rol_id'] == 5) {
            // Si es un barbero, lo mandamos directo a ver sus propias comisiones en lugar del resumen global de la tienda
            header('Location: ' . BASE_URL . '/finanzas/mis_comisiones');
            exit();
        }

        $finanzaModel = $this->model('Finanza');
        
        $barberia_id = ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2) ? null : $_SESSION['barberia_id'];
        
        // Mes actual por defecto
        $ingresos = $finanzaModel->getResumenIngresos($barberia_id);
        $historial = $finanzaModel->getHistorialPagos($barberia_id, 20);

        $total = 0;
        foreach($ingresos as $i) { $total += $i['total_ingresos']; }

        $data = [
            'titulo' => 'Panel de Finanzas | Barber Hub',
            'seccion' => 'finanzas',
            'vista_hija' => '../app/views/dashboard/finanzas/index.php',
            'ingresos' => $ingresos,
            'historial' => $historial,
            'total_mes' => $total
        ];

        $this->view('dashboard/layout', $data);
    }

    public function comisiones() {
        if ($_SESSION['rol_id'] == 5) {
            header('Location: ' . BASE_URL . '/finanzas/mis_comisiones');
            exit();
        }

        $finanzaModel = $this->model('Finanza');
        
        $barberia_id = ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2) ? null : $_SESSION['barberia_id'];
        
        // Comisiones de la semana actual por defecto
        $comisiones = $finanzaModel->getComisionesBarberos($barberia_id);

        $data = [
            'titulo' => 'Comisiones de Barberos | Barber Hub',
            'seccion' => 'comisiones',
            'vista_hija' => '../app/views/dashboard/finanzas/comisiones.php',
            'comisiones' => $comisiones
        ];

        $this->view('dashboard/layout', $data);
    }

    public function cobrar_cita($cita_id = null) {
        if (!$cita_id) {
            header('Location: ' . BASE_URL . '/dashboard/agenda');
            exit();
        }

        $citaModel = $this->model('Cita');
        $cita = $citaModel->getById($cita_id);

        if (!$cita) {
            die("Cita no encontrada.");
        }

        // Si es un barbero, validar que sea su propia cita
        if ($_SESSION['rol_id'] == 5) {
            $userModel = $this->model('User');
            // Como no tenemos el barbero_usuario_id en la consulta getById (solo el cliente_usuario_id),
            // buscamos si el usuario actual es el dueño del barbero_id de esta cita
            $stmt = $userModel->query("SELECT id FROM barberos WHERE usuario_id = :uid", [':uid' => $_SESSION['user_id']]);
            $barbero = $stmt->fetch();
            if (!$barbero || $barbero['id'] != $cita['barbero_id']) {
                die("No tienes permiso para cobrar una cita asignada a otro barbero.");
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodo = $_POST['metodo'] ?? 'Efectivo';
            
            $finanzaModel = $this->model('Finanza');
            $finanzaModel->registrarPago($cita['id'], $cita['precio'], $metodo, $_SESSION['user_id']);
            
            // Actualizar estado de la cita
            $citaModel->actualizarEstado($cita['id'], 'Finalizada');

            // Fidelización: Agregar puntos al cliente
            require_once '../app/models/Cliente.php';
            $clienteModel = new Cliente();
            $clienteModel->agregarPuntos($cita['cliente_id'], $cita['precio']);

            // Auditoría: Registrar la acción
            require_once '../app/models/Auditoria.php';
            $auditoria = new Auditoria();
            $auditoria->registrarAccion($_SESSION['user_id'], "Cobró la cita #{$cita['codigo_unico']} por {$cita['precio']} ({$metodo})");

            if ($_SESSION['rol_id'] == 5) {
                header('Location: ' . BASE_URL . '/finanzas/mis_comisiones?msg=cobrado');
            } else {
                header('Location: ' . BASE_URL . '/finanzas/index?msg=cobrado');
            }
            exit();
        }

        $data = [
            'titulo' => 'Cobrar Cita | Barber Hub',
            'seccion' => 'finanzas',
            'vista_hija' => '../app/views/dashboard/finanzas/checkout.php',
            'cita' => $cita
        ];

        $this->view('dashboard/layout', $data);
    }

    public function mis_comisiones() {
        if ($_SESSION['rol_id'] != 5) {
            header('Location: ' . BASE_URL . '/finanzas/index');
            exit();
        }

        $finanzaModel = $this->model('Finanza');
        // Usar $barberia_id es opcional, el modelo getComisionesBarberos agrupa por barbero_id.
        // Pero necesitamos que solo traiga las comisiones del barbero logueado.
        
        $userModel = $this->model('User');
        $stmt = $userModel->query("SELECT id, porcentaje_comision FROM barberos WHERE usuario_id = :uid", [':uid' => $_SESSION['user_id']]);
        $barbero = $stmt->fetch();
        
        if(!$barbero) die("Error: No se encontró el perfil de barbero asociado a tu usuario.");

        // Traemos TODAS las comisiones de la barbería y filtramos en PHP, o mejor hacemos una consulta personalizada.
        // Por ahora, traemos todo y mostramos solo su ID.
        $comisiones_todas = $finanzaModel->getComisionesBarberos($_SESSION['barberia_id']);
        
        $mi_comision = null;
        foreach($comisiones_todas as $c) {
            if ($c['barbero_id'] == $barbero['id']) {
                $mi_comision = $c;
                break;
            }
        }

        if (!$mi_comision) {
            $mi_comision = [
                'total_servicios' => 0,
                'total_generado' => 0,
                'porcentaje_comision' => $barbero['porcentaje_comision'],
                'total_comision' => 0
            ];
        }

        $data = [
            'titulo' => 'Mis Comisiones | Barber Hub',
            'seccion' => 'mis_comisiones',
            'vista_hija' => '../app/views/dashboard/finanzas/mis_comisiones.php',
            'mi_comision' => $mi_comision
        ];

        $this->view('dashboard/layout', $data);
    }
}
