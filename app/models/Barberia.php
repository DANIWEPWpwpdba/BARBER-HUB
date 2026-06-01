<?php
require_once '../app/models/Model.php';

class Barberia extends Model {

    public function getActivas() {
        return $this->query("SELECT * FROM barberias WHERE estado = 'Activa'")->fetchAll();
    }

    public function getSucursalesByBarberia($barberia_id) {
        $stmt = $this->query("SELECT * FROM sucursales WHERE barberia_id = :id ORDER BY nombre ASC", [':id' => $barberia_id]);
        return $stmt->fetchAll();
    }
    
    public function getAllSucursales() {
        // Para Super Admin
        $stmt = $this->query("SELECT s.*, b.nombre_comercial as barberia_nombre FROM sucursales s JOIN barberias b ON s.barberia_id = b.id ORDER BY b.nombre_comercial ASC, s.nombre ASC");
        return $stmt->fetchAll();
    }

    public function crearBarberia($datos) {
        $sql = "INSERT INTO barberias (nombre_comercial, descripcion, telefono, municipio, estado_ubicacion, calle, url_maps, estado) 
                VALUES (:nombre, :descripcion, :telefono, :municipio, 'Puebla', :direccion, :url_maps, 'Activa')";
        $this->query($sql, [
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'] ?? '',
            ':telefono' => $datos['telefono'],
            ':municipio' => $datos['municipio'] ?? 'Puebla',
            ':direccion' => $datos['direccion'],
            ':url_maps' => $datos['url_maps'] ?? ''
        ]);
        return true;
    }
}
