<?php
class ProveedorModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todos los proveedores
    public function getAll() {
        $sql = "SELECT cod_proveedor, razon_social, ruc, direccion, telefono FROM proveedor";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener proveedor por ID
    public function getById($id) {
        $sql = "SELECT cod_proveedor, razon_social, ruc, direccion, telefono FROM proveedor WHERE cod_proveedor = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear proveedor
    public function create($razon_social, $ruc, $direccion, $telefono) {
        $sql = "INSERT INTO proveedor (razon_social, ruc, direccion, telefono)
                VALUES (:razon_social, :ruc, :direccion, :telefono)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':razon_social', $razon_social, PDO::PARAM_STR);
        $stmt->bindParam(':ruc', $ruc, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Actualizar proveedor
    public function update($id, $razon_social, $ruc, $direccion, $telefono) {
        $sql = "UPDATE proveedor
                SET razon_social = :razon_social,
                    ruc = :ruc,
                    direccion = :direccion,
                    telefono = :telefono
                WHERE cod_proveedor = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':razon_social', $razon_social, PDO::PARAM_STR);
        $stmt->bindParam(':ruc', $ruc, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar proveedor
    public function delete($id) {
        $sql = "DELETE FROM proveedor WHERE cod_proveedor = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
