<?php
class CompraModel {
    public $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function insertCompra($cod_proveedor, $nro_factura, $fecha, $hora, $cod_deposito, $total_compra, $id_user) {
        $estado = 'terminado';

        $sql = "INSERT INTO compra (cod_proveedor, nro_factura, fecha, hora, estado, cod_deposito, total_compra, id_user)
            VALUES (:cod_proveedor, :nro_factura, :fecha, :hora, :estado, :cod_deposito, :total_compra, :id_user)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cod_proveedor', $cod_proveedor, PDO::PARAM_INT);
        $stmt->bindParam(':nro_factura', $nro_factura, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':cod_deposito', $cod_deposito, PDO::PARAM_INT);
        $stmt->bindParam(':total_compra', $total_compra, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }


    // Insertar detalle de compra
    public function insertDetalleCompra($cod_compra, $cod_producto, $cod_deposito, $precio, $cantidad) {
        $sql = "INSERT INTO detalle_compra (cod_compra, cod_producto, cod_deposito, precio, cantidad)
                VALUES (:cod_compra, :cod_producto, :cod_deposito, :precio, :cantidad)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
        $stmt->bindParam(':cod_producto', $cod_producto, PDO::PARAM_INT);
        $stmt->bindParam(':cod_deposito', $cod_deposito, PDO::PARAM_INT);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Actualizar stock (sumar cantidad)
    public function actualizarStock($cod_producto, $cod_deposito, $cantidad) {
        // Verificar si ya existe el registro
        $sql_check = "SELECT cantidad FROM stock WHERE cod_producto = :cod_producto AND cod_deposito = :cod_deposito";
        $stmt = $this->conn->prepare($sql_check);
        $stmt->bindParam(':cod_producto', $cod_producto, PDO::PARAM_INT);
        $stmt->bindParam(':cod_deposito', $cod_deposito, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Actualizar cantidad existente
            $sql_update = "UPDATE stock SET cantidad = cantidad + :cantidad
                           WHERE cod_producto = :cod_producto AND cod_deposito = :cod_deposito";
            $stmt = $this->conn->prepare($sql_update);
        } else {
            // Insertar nuevo registro
            $sql_update = "INSERT INTO stock (cod_producto, cod_deposito, cantidad)
                           VALUES (:cod_producto, :cod_deposito, :cantidad)";
            $stmt = $this->conn->prepare($sql_update);
        }

        $stmt->bindParam(':cod_producto', $cod_producto, PDO::PARAM_INT);
        $stmt->bindParam(':cod_deposito', $cod_deposito, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Obtener proveedores
    public function getProveedores() {
        $sql = "SELECT cod_proveedor, razon_social, ruc FROM proveedor ORDER BY razon_social ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener depósitos
    public function getDepositos() {
        $sql = "SELECT cod_deposito, descrip FROM deposito ORDER BY descrip ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos con unidad de medida
    public function getProductosConUnidad() {
        $sql = "SELECT p.cod_producto, p.p_descrip, p.precio, u.u_descrip AS unidad_descrip
            FROM producto p
            JOIN u_medida u ON p.id_u_medida = u.id_u_medida
            ORDER BY p.p_descrip ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Obtener todas las compras con detalles del proveedor y depósito
    public function getAllCompras() {
        $sql = "SELECT c.cod_compra, c.nro_factura, c.fecha, c.hora, c.total_compra, c.estado,
                   p.razon_social, d.descrip AS deposito
            FROM compra c
            JOIN proveedor p ON c.cod_proveedor = p.cod_proveedor
            JOIN deposito d ON c.cod_deposito = d.cod_deposito
            WHERE c.estado != 'anulado'
            ORDER BY c.cod_compra DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function anularCompra($cod_compra) {
        // 1. Obtener los productos y cantidades de la compra
        $sqlDetalle = "SELECT cod_producto, cod_deposito, cantidad FROM detalle_compra WHERE cod_compra = :cod_compra";
        $stmtDetalle = $this->conn->prepare($sqlDetalle);
        $stmtDetalle->bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
        $stmtDetalle->execute();
        $detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

        // 2. Restar del stock cada producto
        foreach ($detalles as $item) {
            $sqlStock = "UPDATE stock SET cantidad = cantidad - :cantidad
                     WHERE cod_producto = :cod_producto AND cod_deposito = :cod_deposito";
            $stmtStock = $this->conn->prepare($sqlStock);
            $stmtStock->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
            $stmtStock->bindParam(':cod_producto', $item['cod_producto'], PDO::PARAM_INT);
            $stmtStock->bindParam(':cod_deposito', $item['cod_deposito'], PDO::PARAM_INT);
            $stmtStock->execute();
        }

        // 3. Actualizar estado de la compra
        $sqlUpdate = "UPDATE compra SET estado = 'anulado' WHERE cod_compra = :cod_compra";
        $stmtUpdate = $this->conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':cod_compra', $cod_compra, PDO::PARAM_INT);
        $stmtUpdate->execute();
    }
}
