<?php
/**
 * Barber Hub - Base Model
 * Maneja la conexión PDO a MySQL para todas las entidades.
 */

class Model {
    protected $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->db = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            die("Error de conexión a la Base de Datos: " . $e->getMessage());
        }
    }

    /**
     * Ejecuta una consulta preparada con parámetros
     */
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
