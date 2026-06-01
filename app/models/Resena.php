<?php
require_once '../app/models/Model.php';

class Resena extends Model {
    
    public function crear($cita_id, $cliente_id, $barbero_id, $barberia_id, $calificacion, $comentario) {
        // Verificar si la reseña ya existe para esta cita
        $stmt = $this->query("SELECT id FROM resenas WHERE cita_id = :cid", [':cid' => $cita_id]);
        if ($stmt->fetch()) {
            return false; // Ya se dejó reseña para esta cita
        }

        $sql = "INSERT INTO resenas (cita_id, cliente_id, barbero_id, barberia_id, calificacion, comentario) 
                VALUES (:ci, :cl, :b, :ba, :cal, :com)";
        
        $this->query($sql, [
            ':ci' => $cita_id,
            ':cl' => $cliente_id,
            ':b' => $barbero_id,
            ':ba' => $barberia_id,
            ':cal' => $calificacion,
            ':com' => $comentario
        ]);
        return true;
    }

    public function getPorBarbero($barbero_id) {
        $sql = "SELECT r.*, c.nombre as cliente_nombre 
                FROM resenas r
                JOIN clientes cli ON r.cliente_id = cli.id
                JOIN usuarios c ON cli.usuario_id = c.id
                WHERE r.barbero_id = :bid
                ORDER BY r.fecha DESC";
        return $this->query($sql, [':bid' => $barbero_id])->fetchAll();
    }

    public function getPromedioBarbero($barbero_id) {
        $sql = "SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM resenas WHERE barbero_id = :bid";
        return $this->query($sql, [':bid' => $barbero_id])->fetch();
    }
}
