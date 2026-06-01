<?php
require_once '../app/models/Model.php';

class Auditoria extends Model {
    
    public function registrarAccion($usuario_id, $accion, $resultado = 'Exito') {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
        
        $sql = "INSERT INTO auditoria (usuario_id, accion, resultado, direccion_ip) 
                VALUES (:uid, :acc, :res, :ip)";
        
        $this->query($sql, [
            ':uid' => $usuario_id,
            ':acc' => $accion,
            ':res' => $resultado,
            ':ip'  => $ip
        ]);
    }

    public function getHistorialGlobal($limit = 100) {
        $sql = "SELECT a.*, u.nombre, r.nombre as rol
                FROM auditoria a
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                LEFT JOIN roles r ON u.rol_id = r.id
                ORDER BY a.fecha DESC
                LIMIT " . (int)$limit;
        
        return $this->query($sql)->fetchAll();
    }
}
