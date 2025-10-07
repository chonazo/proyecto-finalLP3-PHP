<?php
class StockModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getStock() {
        $sql = "SELECT p.p_descrip, p.precio, d.descrip, s.cantidad
                FROM stock s
                INNER JOIN producto p ON s.cod_producto = p.cod_producto
                INNER JOIN deposito d ON s.cod_deposito = d.cod_deposito";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
