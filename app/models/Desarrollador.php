<?php
require_once '../app/models/Model.php';

class Desarrollador extends Model {

    public function getActivos() {
        $stmt = $this->query("SELECT * FROM desarrolladores WHERE estado = 'Activo' ORDER BY orden ASC");
        return $stmt->fetchAll();
    }

    public function getAll() {
        $stmt = $this->query("SELECT * FROM desarrolladores ORDER BY orden ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->query("SELECT * FROM desarrolladores WHERE id = :id", [':id' => $id]);
        return $stmt->fetch();
    }

    public function crear($data, $creado_por) {
        $sql = "INSERT INTO desarrolladores 
                (nombre, cargo, descripcion, foto_url, tecnologias, contribuciones,
                 instagram, facebook, linkedin, github, sitio_web, estado, orden, creado_por)
                VALUES (:nombre, :cargo, :descripcion, :foto_url, :tecnologias, :contribuciones,
                        :instagram, :facebook, :linkedin, :github, :sitio_web, :estado, :orden, :creado_por)";
        $this->query($sql, [
            ':nombre'         => $data['nombre'] ?? '',
            ':cargo'          => $data['cargo'] ?? '',
            ':descripcion'    => $data['descripcion'] ?? '',
            ':foto_url'       => $data['foto_url'] ?? null,
            ':tecnologias'    => $data['tecnologias'] ?? null,
            ':contribuciones' => $data['contribuciones'] ?? null,
            ':instagram'      => $data['instagram'] ?? null,
            ':facebook'       => $data['facebook'] ?? null,
            ':linkedin'       => $data['linkedin'] ?? null,
            ':github'         => $data['github'] ?? null,
            ':sitio_web'      => $data['sitio_web'] ?? null,
            ':estado'         => $data['estado'] ?? 'Activo',
            ':orden'          => $data['orden'] ?? 99,
            ':creado_por'     => $creado_por,
        ]);
    }

    public function actualizar($id, $data) {
        $sql = "UPDATE desarrolladores SET
                nombre=:nombre, cargo=:cargo, descripcion=:descripcion,
                foto_url=:foto_url, tecnologias=:tecnologias, contribuciones=:contribuciones,
                instagram=:instagram, facebook=:facebook, linkedin=:linkedin,
                github=:github, sitio_web=:sitio_web, estado=:estado, orden=:orden
                WHERE id=:id";
        $this->query($sql, [
            ':nombre'         => $data['nombre'],
            ':cargo'          => $data['cargo'],
            ':descripcion'    => $data['descripcion'],
            ':foto_url'       => $data['foto_url'] ?? null,
            ':tecnologias'    => $data['tecnologias'] ?? null,
            ':contribuciones' => $data['contribuciones'] ?? null,
            ':instagram'      => $data['instagram'] ?? null,
            ':facebook'       => $data['facebook'] ?? null,
            ':linkedin'       => $data['linkedin'] ?? null,
            ':github'         => $data['github'] ?? null,
            ':sitio_web'      => $data['sitio_web'] ?? null,
            ':estado'         => $data['estado'],
            ':orden'          => $data['orden'] ?? 99,
            ':id'             => $id,
        ]);
    }

    public function toggleEstado($id) {
        $this->query(
            "UPDATE desarrolladores SET estado = IF(estado='Activo','Inactivo','Activo') WHERE id = :id",
            [':id' => $id]
        );
    }
}
