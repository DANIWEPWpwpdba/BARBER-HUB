<?php
require_once __DIR__ . '/Model.php';
class Servicio extends Model {
    
    public function getAll() {
        return $this->query("SELECT s.*, b.nombre_comercial as barberia_nombre 
                             FROM servicios s 
                             JOIN barberias b ON s.barberia_id = b.id 
                             ORDER BY b.nombre_comercial, s.nombre")->fetchAll();
    }

    public function getByBarberia($barberia_id) {
        return $this->query("SELECT * FROM servicios WHERE barberia_id = :id AND estado = 'Activo' ORDER BY nombre", [':id' => $barberia_id])->fetchAll();
    }

    public function getById($id) {
        return $this->query("SELECT * FROM servicios WHERE id = :id", [':id' => $id])->fetch();
    }

    public function crear($datos) {
        $sql = "INSERT INTO servicios (barberia_id, nombre, descripcion, duracion_minutos, precio, estado) 
                VALUES (:b_id, :nombre, :desc, :dur, :precio, 'Activo')";
        $this->query($sql, [
            ':b_id' => $datos['barberia_id'],
            ':nombre' => $datos['nombre'],
            ':desc' => $datos['descripcion'] ?? '',
            ':dur' => $datos['duracion_minutos'],
            ':precio' => $datos['precio']
        ]);
        return true;
    }

    public function toggleEstado($id) {
        $s = $this->getById($id);
        if ($s) {
            $nuevo = $s['estado'] === 'Activo' ? 'Inactivo' : 'Activo';
            $this->query("UPDATE servicios SET estado = :e WHERE id = :id", [':e' => $nuevo, ':id' => $id]);
        }
    }
}
