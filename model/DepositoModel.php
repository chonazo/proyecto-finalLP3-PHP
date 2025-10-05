<?php
class DepositoModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todos los depósitos
    public function getAll() {
        $sql = "SELECT cod_deposito, descrip FROM deposito";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener depósito por ID
    public function getById($id) {
        $sql = "SELECT cod_deposito, descrip FROM deposito WHERE cod_deposito = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear depósito
    public function create($descrip) {
        $sql = "INSERT INTO deposito (descrip) VALUES (:descrip)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descrip', $descrip, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Actualizar depósito
    public function update($id, $descrip) {
        $sql = "UPDATE deposito SET descrip = :descrip WHERE cod_deposito = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descrip', $descrip, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar depósito
    public function delete($id) {
        $sql = "DELETE FROM deposito WHERE cod_deposito = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
