<?php
class UnidadMedidaModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todas las unidades de medida
    public function getAll() {
        $sql = "SELECT id_u_medida, u_descrip FROM u_medida";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener unidad de medida por ID
    public function getById($id) {
        $sql = "SELECT id_u_medida, u_descrip FROM u_medida WHERE id_u_medida = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear unidad de medida
    public function create($descripcion) {
        $sql = "INSERT INTO u_medida (u_descrip) VALUES (:descripcion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Actualizar unidad de medida
    public function update($id, $descripcion) {
        $sql = "UPDATE u_medida SET u_descrip = :descripcion WHERE id_u_medida = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar unidad de medida
    public function delete($id) {
        $sql = "DELETE FROM u_medida WHERE id_u_medida = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
