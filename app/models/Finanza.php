<?php
require_once '../app/models/Model.php';

class Finanza extends Model {

    // Registra el pago en la tabla pagos
    public function registrarPago($cita_id, $monto, $metodo, $validado_por) {
        $sql = "INSERT INTO pagos (cita_id, monto, metodo, estado, validado_por) 
                VALUES (:cita_id, :monto, :metodo, 'Confirmado', :validado_por)";
        
        return $this->query($sql, [
            ':cita_id' => $cita_id,
            ':monto' => $monto,
            ':metodo' => $metodo,
            ':validado_por' => $validado_por
        ]);
    }

    // Obtener resumen financiero (Ingresos por método) para un rango de fechas o una barbería
    public function getResumenIngresos($barberia_id = null, $fecha_inicio = null, $fecha_fin = null) {
        $where = "p.estado = 'Confirmado'";
        $params = [];

        if ($barberia_id) {
            $where .= " AND c.barberia_id = :barberia_id";
            $params[':barberia_id'] = $barberia_id;
        }

        if ($fecha_inicio && $fecha_fin) {
            $where .= " AND DATE(p.fecha_pago) BETWEEN :inicio AND :fin";
            $params[':inicio'] = $fecha_inicio;
            $params[':fin'] = $fecha_fin;
        } else {
            // Por defecto, mes actual
            $where .= " AND MONTH(p.fecha_pago) = MONTH(CURRENT_DATE()) AND YEAR(p.fecha_pago) = YEAR(CURRENT_DATE())";
        }

        $sql = "SELECT p.metodo, SUM(p.monto) as total_ingresos, COUNT(p.id) as total_operaciones 
                FROM pagos p 
                JOIN citas c ON p.cita_id = c.id 
                WHERE $where 
                GROUP BY p.metodo";
                
        return $this->query($sql, $params)->fetchAll();
    }

    // Obtener historial de pagos
    public function getHistorialPagos($barberia_id = null, $limit = 50) {
        $where = "";
        $params = [];

        if ($barberia_id) {
            $where = "WHERE c.barberia_id = :barberia_id";
            $params[':barberia_id'] = $barberia_id;
        }

        $sql = "SELECT p.*, c.codigo_unico, s.nombre as servicio, s.precio, u_cliente.nombre as cliente, u_barbero.nombre as barbero
                FROM pagos p
                JOIN citas c ON p.cita_id = c.id
                JOIN servicios s ON c.servicio_id = s.id
                JOIN clientes cli ON c.cliente_id = cli.id
                JOIN usuarios u_cliente ON cli.usuario_id = u_cliente.id
                JOIN barberos b ON c.barbero_id = b.id
                JOIN usuarios u_barbero ON b.usuario_id = u_barbero.id
                $where
                ORDER BY p.fecha_pago DESC
                LIMIT " . (int)$limit;
                
        return $this->query($sql, $params)->fetchAll();
    }

    // Calcular comisiones de los barberos en un periodo
    public function getComisionesBarberos($barberia_id = null, $fecha_inicio = null, $fecha_fin = null) {
        $where = "p.estado = 'Confirmado'";
        $params = [];

        if ($barberia_id) {
            $where .= " AND c.barberia_id = :barberia_id";
            $params[':barberia_id'] = $barberia_id;
        }

        if ($fecha_inicio && $fecha_fin) {
            $where .= " AND DATE(p.fecha_pago) BETWEEN :inicio AND :fin";
            $params[':inicio'] = $fecha_inicio;
            $params[':fin'] = $fecha_fin;
        } else {
            // Por defecto, semana actual
            $where .= " AND YEARWEEK(p.fecha_pago, 1) = YEARWEEK(CURRENT_DATE(), 1)";
        }

        $sql = "SELECT 
                    b.id as barbero_id, 
                    u.nombre as barbero_nombre, 
                    b.porcentaje_comision,
                    COUNT(p.id) as total_servicios,
                    SUM(p.monto) as total_generado,
                    SUM(p.monto * (b.porcentaje_comision / 100)) as total_comision
                FROM pagos p
                JOIN citas c ON p.cita_id = c.id
                JOIN barberos b ON c.barbero_id = b.id
                JOIN usuarios u ON b.usuario_id = u.id
                WHERE $where
                GROUP BY b.id
                ORDER BY total_comision DESC";
                
        return $this->query($sql, $params)->fetchAll();
    }
}
