<?php
require_once '../app/models/Model.php';

class Cliente extends Model {

    public function getByUsuarioId($usuario_id) {
        $sql = "SELECT c.*, u.nombre, u.fotografia, u.correo 
                FROM clientes c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.usuario_id = :uid";
        return $this->query($sql, [':uid' => $usuario_id])->fetch();
    }

    public function getById($cliente_id) {
        $sql = "SELECT c.*, u.nombre, u.fotografia, u.correo 
                FROM clientes c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.id = :cid";
        return $this->query($sql, [':cid' => $cliente_id])->fetch();
    }

    public function agregarPuntos($cliente_id, $monto_cobrado) {
        // 1 punto por cada $10
        $puntos_ganados = floor($monto_cobrado / 10);
        
        $cliente = $this->getById($cliente_id);
        if (!$cliente) return false;

        $nuevos_puntos = $cliente['puntos_acumulados'] + $puntos_ganados;
        
        // Calcular nuevo nivel
        $nuevo_nivel = 'Bronce';
        if ($nuevos_puntos >= 100) $nuevo_nivel = 'Plata';
        if ($nuevos_puntos >= 500) $nuevo_nivel = 'Oro';
        if ($nuevos_puntos >= 1000) $nuevo_nivel = 'Diamante';
        if ($nuevos_puntos >= 5000) $nuevo_nivel = 'Leyenda';

        $sql = "UPDATE clientes SET puntos_acumulados = :pts, nivel = :lvl WHERE id = :cid";
        $this->query($sql, [
            ':pts' => $nuevos_puntos,
            ':lvl' => $nuevo_nivel,
            ':cid' => $cliente_id
        ]);

        return [
            'puntos_ganados' => $puntos_ganados,
            'nuevos_puntos' => $nuevos_puntos,
            'nuevo_nivel' => $nuevo_nivel,
            'subio_nivel' => ($nuevo_nivel !== $cliente['nivel'])
        ];
    }
}
