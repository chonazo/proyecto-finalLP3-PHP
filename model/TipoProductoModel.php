<?php
class TipoProductoModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todos los tipos de producto
    public function getAll() {
        $sql = "SELECT cod_tipo_prod, t_p_descrip FROM tipo_producto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener tipo de producto por ID
    public function getById($id) {
        $sql = "SELECT cod_tipo_prod, t_p_descrip FROM tipo_producto WHERE cod_tipo_prod = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear tipo de producto
    public function create($descripcion) {
        $sql = "INSERT INTO tipo_producto (t_p_descrip) VALUES (:descripcion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Actualizar tipo de producto
    public function update($id, $descripcion) {
        $sql = "UPDATE tipo_producto SET t_p_descrip = :descripcion WHERE cod_tipo_prod = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar tipo de producto
    public function delete($id) {
        $sql = "DELETE FROM tipo_producto WHERE cod_tipo_prod = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
