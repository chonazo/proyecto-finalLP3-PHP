<?php
class ClienteModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $sql = "SELECT cl.id_cliente, cl.ci_ruc, cl.cli_nombre, cl.cli_apellido, 
                cl.cli_direccion, cl.cli_telefono, ci.descrip_ciudad
                FROM clientes cl LEFT JOIN ciudad ci ON cl.cod_ciudad = ci.cod_ciudad";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener cliente por ID
    public function getById($id) {
        $sql = "SELECT cl.id_cliente, cl.ci_ruc, cl.cli_nombre, cl.cli_apellido,
                       cl.cli_direccion, cl.cli_telefono, cl.cod_ciudad
                FROM clientes cl WHERE cl.id_cliente = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear cliente
    public function create($ci_ruc, $cli_nombre, $cli_apellido, $cli_direccion, $cli_telefono, $cod_ciudad) {
        $sql = "INSERT INTO clientes (ci_ruc, cli_nombre, cli_apellido, cli_direccion, cli_telefono, cod_ciudad)
                VALUES (:ci_ruc, :cli_nombre, :cli_apellido, :cli_direccion, :cli_telefono, :cod_ciudad)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ci_ruc', $ci_ruc, PDO::PARAM_STR);
        $stmt->bindParam(':cli_nombre', $cli_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':cli_apellido', $cli_apellido, PDO::PARAM_STR);
        $stmt->bindParam(':cli_direccion', $cli_direccion, PDO::PARAM_STR);
        $stmt->bindParam(':cli_telefono', $cli_telefono, PDO::PARAM_STR);
        $stmt->bindParam(':cod_ciudad', $cod_ciudad, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Actualizar cliente
    public function update($id, $ci_ruc, $cli_nombre, $cli_apellido, $cli_direccion, $cli_telefono, $cod_ciudad) {
        $sql = "UPDATE clientes SET ci_ruc = :ci_ruc, cli_nombre = :cli_nombre, cli_apellido = :cli_apellido, cli_direccion = :cli_direccion, 
                cli_telefono = :cli_telefono, cod_ciudad = :cod_ciudad WHERE id_cliente = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ci_ruc', $ci_ruc, PDO::PARAM_STR);
        $stmt->bindParam(':cli_nombre', $cli_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':cli_apellido', $cli_apellido, PDO::PARAM_STR);
        $stmt->bindParam(':cli_direccion', $cli_direccion, PDO::PARAM_STR);
        $stmt->bindParam(':cli_telefono', $cli_telefono, PDO::PARAM_STR);
        $stmt->bindParam(':cod_ciudad', $cod_ciudad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar cliente
    public function delete($id) {
        $sql = "DELETE FROM clientes WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}