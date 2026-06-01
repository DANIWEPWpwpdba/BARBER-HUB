<?php
require_once __DIR__ . '/Model.php';
class Cita extends Model {
    
    public function crear($datos) {
        $codigo = strtoupper(substr(uniqid('BH-'), 0, 8)); // Ej: BH-64A1B2
        $sql = "INSERT INTO citas (codigo_unico, barberia_id, cliente_id, barbero_id, servicio_id, fecha, hora, duracion_minutos, estado) 
                VALUES (:codigo, :barb, :cliente, :barbero, :servicio, :fecha, :hora, :duracion, 'Confirmada')"; // Confirmada automáticamente según reglas
        
        $this->query($sql, [
            ':codigo' => $codigo,
            ':barb' => $datos['barberia_id'],
            ':cliente' => $datos['cliente_id'],
            ':barbero' => $datos['barbero_id'],
            ':servicio' => $datos['servicio_id'],
            ':fecha' => $datos['fecha'],
            ':hora' => $datos['hora'],
            ':duracion' => $datos['duracion_minutos']
        ]);
        
        return $codigo;
    }

    public function getCitasDiaBarbero($barbero_id, $fecha) {
        return $this->query("SELECT hora, duracion_minutos FROM citas WHERE barbero_id = :b AND fecha = :f AND estado NOT IN ('Cancelada', 'No asistio')", 
            [':b' => $barbero_id, ':f' => $fecha])->fetchAll();
    }

    public function getAgendaGeneral($barberia_id, $fecha) {
        $sql = "SELECT c.*, ub.nombre as barbero_nombre, uc.nombre as cliente_nombre, s.nombre as servicio_nombre 
                FROM citas c
                JOIN barberos b ON c.barbero_id = b.id
                JOIN usuarios ub ON b.usuario_id = ub.id
                JOIN clientes cl ON c.cliente_id = cl.id
                JOIN usuarios uc ON cl.usuario_id = uc.id
                JOIN servicios s ON c.servicio_id = s.id
                WHERE c.barberia_id = :b_id AND c.fecha = :fecha
                ORDER BY c.hora ASC";
        return $this->query($sql, [':b_id' => $barberia_id, ':fecha' => $fecha])->fetchAll();
    }

    public function getAgendaBarbero($barbero_id, $fecha) {
        $sql = "SELECT c.*, uc.nombre as cliente_nombre, s.nombre as servicio_nombre 
                FROM citas c
                JOIN clientes cl ON c.cliente_id = cl.id
                JOIN usuarios uc ON cl.usuario_id = uc.id
                JOIN servicios s ON c.servicio_id = s.id
                WHERE c.barbero_id = :b_id AND c.fecha = :fecha
                ORDER BY c.hora ASC";
        return $this->query($sql, [':b_id' => $barbero_id, ':fecha' => $fecha])->fetchAll();
    }

    public function calcularHorariosDisponibles($barbero_id, $fecha, $duracion_servicio) {
        // Horario fijo de 10:00 a 20:00
        $hora_inicio = strtotime("10:00:00");
        $hora_fin = strtotime("20:00:00");
        
        $citas_ocupadas = $this->getCitasDiaBarbero($barbero_id, $fecha);
        $ocupados = [];
        foreach($citas_ocupadas as $c) {
            $inicio = strtotime($c['hora']);
            $fin = $inicio + ($c['duracion_minutos'] * 60);
            $ocupados[] = ['inicio' => $inicio, 'fin' => $fin];
        }

        $disponibles = [];
        // Intervalos de 30 minutos
        for ($h = $hora_inicio; $h <= $hora_fin - ($duracion_servicio * 60); $h += 1800) {
            $fin_propuesto = $h + ($duracion_servicio * 60);
            $conflicto = false;
            foreach ($ocupados as $o) {
                if (($h >= $o['inicio'] && $h < $o['fin']) || 
                    ($fin_propuesto > $o['inicio'] && $fin_propuesto <= $o['fin']) ||
                    ($h <= $o['inicio'] && $fin_propuesto >= $o['fin'])) {
                    $conflicto = true;
                    break;
                }
            }
            if (!$conflicto) {
                $disponibles[] = date("H:i", $h);
            }
        }
        return $disponibles;
    }
    
    public function actualizarEstado($id, $estado) {
        $this->query("UPDATE citas SET estado = :e WHERE id = :id", [':e' => $estado, ':id' => $id]);
    }

    public function getById($id) {
        $sql = "SELECT c.*, s.precio, s.nombre as servicio_nombre, cli.usuario_id as cliente_usuario_id 
                FROM citas c 
                JOIN servicios s ON c.servicio_id = s.id 
                JOIN clientes cli ON c.cliente_id = cli.id
                WHERE c.id = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        return $stmt->fetch();
    }
}
