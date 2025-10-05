<?php
class ReportModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Método genérico para ejecutar consultas
    public function getData($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  


}
