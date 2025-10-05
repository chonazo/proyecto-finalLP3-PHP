<?php

class DepartamentModel {
    
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getAll()  {
        // Corrección: se usa 'dep_descripcion' en lugar de 'descripcion'
        $sql = "SELECT id_departamento, dep_descripcion FROM departamento ORDER BY dep_descripcion ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)  {
        // Corrección: se usa 'dep_descripcion' en lugar de 'descripcion'
        $sql = "SELECT id_departamento, dep_descripcion FROM departamento WHERE id_departamento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($dep_descripcion) {
        // Corrección: se usa 'dep_descripcion' en lugar de 'descripcion'
        $sql = "INSERT INTO departamento (dep_descripcion) VALUES (:dep_descripcion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':dep_descripcion', $dep_descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id, $dep_descripcion) {
        // Corrección: se usa 'dep_descripcion' en lugar de 'descripcion'
        $sql = "UPDATE departamento SET dep_descripcion = :dep_descripcion WHERE id_departamento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':dep_descripcion', $dep_descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM departamento WHERE id_departamento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
