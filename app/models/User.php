<?php
require_once '../app/models/Model.php';

class User extends Model {
    
    public function findByEmail($email) {
        $stmt = $this->query("SELECT * FROM usuarios WHERE correo = :correo", [':correo' => $email]);
        return $stmt->fetch();
    }

    public function createMasterUser($nombre, $correo, $password, $rol_id) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        
        // Verificar si ya existe
        if ($this->findByEmail($correo)) {
            return false;
        }

        $sql = "INSERT INTO usuarios (rol_id, barberia_id, nombre, correo, password, estado) 
                VALUES (:rol_id, NULL, :nombre, :correo, :password, 'Activo')";
        
        $this->query($sql, [
            ':rol_id' => $rol_id,
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':password' => $hashed
        ]);
        
        
        return true;
    }

    public function createClient($nombre, $correo, $telefono, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        
        // Verificar si ya existe
        if ($this->findByEmail($correo)) {
            return ['success' => false, 'error' => 'El correo ya está registrado.'];
        }

        // El rol de Cliente es ID 6 según el schema inicial
        $rol_id = 6;
        
        try {
            $sqlUser = "INSERT INTO usuarios (rol_id, barberia_id, nombre, correo, telefono, password, estado) 
                        VALUES (:rol_id, NULL, :nombre, :correo, :telefono, :password, 'Pendiente')";
            
            $this->query($sqlUser, [
                ':rol_id'   => $rol_id,
                ':nombre'   => $nombre,
                ':correo'   => $correo,
                ':telefono' => $telefono,
                ':password' => $hashed
            ]);
            
            // Obtener el ID del usuario insertado
            $stmt = $this->query("SELECT LAST_INSERT_ID() as id");
            $res = $stmt->fetch();
            $usuario_id = $res['id'];
            
            // Generar un código QR único temporal o hash para el cliente
            $qr_unico = 'QR-' . strtoupper(uniqid()) . '-' . $usuario_id;

            // Insertar en la tabla clientes (barberia_id es NULL porque es global)
            $sqlCliente = "INSERT INTO clientes (usuario_id, barberia_id, qr_unico) 
                           VALUES (:usuario_id, NULL, :qr_unico)";
            
            $this->query($sqlCliente, [
                ':usuario_id' => $usuario_id,
                ':qr_unico'   => $qr_unico
            ]);

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Error al registrar el cliente: ' . $e->getMessage()];
        }
    }
}
