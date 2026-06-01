<?php
require_once '../app/models/Model.php';

class Barbero extends Model {

    public function getAllByBarberia($barberia_id) {
        $sql = "SELECT b.*, u.nombre, u.correo, u.telefono, u.fotografia, s.nombre as sucursal_nombre 
                FROM barberos b 
                JOIN usuarios u ON b.usuario_id = u.id 
                LEFT JOIN sucursales s ON b.sucursal_id = s.id 
                WHERE b.barberia_id = :id ORDER BY u.nombre ASC";
        return $this->query($sql, [':id' => $barberia_id])->fetchAll();
    }
    
    public function getAll() {
        // Para Super Admin
        $sql = "SELECT b.*, u.nombre, u.correo, u.telefono, u.fotografia, s.nombre as sucursal_nombre, bb.nombre_comercial as barberia_nombre 
                FROM barberos b 
                JOIN usuarios u ON b.usuario_id = u.id 
                LEFT JOIN sucursales s ON b.sucursal_id = s.id 
                JOIN barberias bb ON b.barberia_id = bb.id
                ORDER BY bb.nombre_comercial ASC, u.nombre ASC";
        return $this->query($sql)->fetchAll();
    }

    public function crearBarbero($datos_usuario, $datos_barbero) {
        try {
            // Iniciar transacción en PDO a través del Model (si se expone, si no manual)
            // Model base probablemente no exponga beginTransaction, lo haré directamente con la conexion
            // Si Model.php usa PDO nativo, podemos no usar transacción o añadir un método
            // Como no estoy seguro del contenido exacto de Model.php para transacciones, haré los inserts.
            
            // Comprobar si correo existe
            $stmt = $this->query("SELECT id FROM usuarios WHERE correo = :correo", [':correo' => $datos_usuario['correo']]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => 'El correo ya está registrado en el sistema.'];
            }

            // 1. Insertar Usuario (Rol 5 = Barbero)
            $hashed_pass = password_hash($datos_usuario['password'], PASSWORD_BCRYPT);
            $sqlUser = "INSERT INTO usuarios (rol_id, barberia_id, nombre, correo, telefono, password, estado) 
                        VALUES (5, :barberia_id, :nombre, :correo, :telefono, :password, 'Activo')";
            
            $this->query($sqlUser, [
                ':barberia_id' => $datos_barbero['barberia_id'],
                ':nombre'      => $datos_usuario['nombre'],
                ':correo'      => $datos_usuario['correo'],
                ':telefono'    => $datos_usuario['telefono'],
                ':password'    => $hashed_pass
            ]);

            // Obtener el ID
            $stmt = $this->query("SELECT LAST_INSERT_ID() as id");
            $usuario_id = $stmt->fetch()['id'];

            // 2. Insertar Barbero
            $sqlBarbero = "INSERT INTO barberos (usuario_id, barberia_id, sucursal_id, biografia, anios_experiencia) 
                           VALUES (:usuario_id, :barberia_id, :sucursal_id, :biografia, :anios_experiencia)";
            
            $this->query($sqlBarbero, [
                ':usuario_id'        => $usuario_id,
                ':barberia_id'       => $datos_barbero['barberia_id'],
                ':sucursal_id'       => $datos_barbero['sucursal_id'] ?: null,
                ':biografia'         => $datos_barbero['biografia'],
                ':anios_experiencia' => $datos_barbero['anios_experiencia']
            ]);

            return ['success' => true, 'usuario_id' => $usuario_id];

        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Error al crear barbero: ' . $e->getMessage()];
        }
    }
}
