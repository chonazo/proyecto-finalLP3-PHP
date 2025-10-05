<?php
class CiudadModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todas las ciudades con su departamento
    public function getAll() {
        $sql = "SELECT c.cod_ciudad, 
                   c.descrip_ciudad, 
                   d.dep_descripcion
            FROM ciudad c
            JOIN departamento d ON c.id_departamento = d.id_departamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }

    // Obtener ciudad por ID
    public function getById($id) {
        $sql = "SELECT ciu.cod_ciudad, ciu.descrip_ciudad, 
                       dep.id_departamento, dep.dep_descripcion
                FROM ciudad ciu
                JOIN departamento dep 
                  ON ciu.id_departamento = dep.id_departamento
                WHERE ciu.cod_ciudad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear ciudad
    public function create($descrip_ciudad, $id_departamento) {
        $sql = "INSERT INTO ciudad (descrip_ciudad, id_departamento) 
                VALUES (:descrip_ciudad, :id_departamento)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descrip_ciudad', $descrip_ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar ciudad
    public function update($id, $descrip_ciudad, $id_departamento) {
        $sql = "UPDATE ciudad 
                   SET descrip_ciudad = :descrip_ciudad, 
                       id_departamento = :id_departamento 
                 WHERE cod_ciudad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descrip_ciudad', $descrip_ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar ciudad
    public function delete($id) {
        $sql = "DELETE FROM ciudad WHERE cod_ciudad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

