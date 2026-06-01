<?php
class BarberiaController extends Controller {
    
    public function index($slug = '') {
        // En un sistema real, aquí buscaríamos la barbería por su slug en la base de datos.
        // Como el slug lo generamos dinámicamente reemplazando espacios con guiones,
        // necesitamos buscar la barbería cuyo nombre coincida.
        
        if (empty($slug)) {
            header('Location: ' . BASE_URL);
            exit();
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
            die("Micrositio no encontrado."); // TODO: Vista 404 elegante
        }

        // Obtener los barberos de esta sucursal específica
        $barberoModel = $this->model('Barbero');
        $barberos = $barberoModel->getAllByBarberia($barberia_actual['id']);

        $data = [
            'titulo' => $barberia_actual['nombre_comercial'] . ' | Micrositio',
            'barberia' => $barberia_actual,
            'barberos' => $barberos
        ];

        $this->view('barberia/index', $data);
    }
}
