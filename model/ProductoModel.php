<?php
class ProductoModel {

    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Obtener todos los productos con tipo y unidad
    public function getAll() {
        $sql = "SELECT p.cod_producto, p.p_descrip, p.precio, tp.t_p_descrip AS tipo_descrip,
                    um.u_descrip AS unidad_descrip FROM producto p
                JOIN tipo_producto tp ON p.cod_tipo_prod = tp.cod_tipo_prod
                JOIN u_medida um ON p.id_u_medida = um.id_u_medida";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener producto por ID
    public function getById($id) {
        $sql = "SELECT 
                    cod_producto,
                    cod_tipo_prod,
                    id_u_medida,
                    p_descrip,
                    precio
                FROM producto
                WHERE cod_producto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear producto
    public function create($tipo, $unidad, $descripcion, $precio) {
        $sql = "INSERT INTO producto (cod_tipo_prod, id_u_medida, p_descrip, precio)
                VALUES (:tipo, :unidad, :descripcion, :precio)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
        $stmt->bindParam(':unidad', $unidad, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar producto
    public function update($id, $tipo, $unidad, $descripcion, $precio) {
        $sql = "UPDATE producto
                SET cod_tipo_prod = :tipo,
                    id_u_medida = :unidad,
                    p_descrip = :descripcion,
                    precio = :precio
                WHERE cod_producto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
        $stmt->bindParam(':unidad', $unidad, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar producto
    public function delete($id) {
        $sql = "DELETE FROM producto WHERE cod_producto = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
