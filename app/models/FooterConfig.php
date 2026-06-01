<?php
require_once '../app/models/Model.php';

class FooterConfig extends Model {

    public function getAll() {
        $stmt = $this->query("SELECT clave, valor FROM configuracion_footer");
        $rows = $stmt->fetchAll();
        $cfg = [];
        foreach ($rows as $row) {
            $cfg[$row['clave']] = $row['valor'];
        }
        return $cfg;
    }

    public function get($clave) {
        $stmt = $this->query(
            "SELECT valor FROM configuracion_footer WHERE clave = :clave",
            [':clave' => $clave]
        );
        $row = $stmt->fetch();
        return $row ? $row['valor'] : '';
    }

    public function actualizar($clave, $valor) {
        $this->query(
            "UPDATE configuracion_footer SET valor = :valor WHERE clave = :clave",
            [':valor' => $valor, ':clave' => $clave]
        );
    }
}
