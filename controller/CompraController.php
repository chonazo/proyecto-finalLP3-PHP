<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/CompraModel.php';

class CompraController {
    private $compraModel;

    public function __construct(PDO $conn) {
        $this->compraModel = new CompraModel($conn);
    }

    // Listar compras
    public function indexCompra() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $compras = $this->compraModel->getAllCompras();

        $data = [
            'Title' => 'Compras Registradas',
            'compras' => $compras
        ];

        View::render('compra/viewCompra', $data);
    }


    // Mostrar formulario de compra
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $proveedores = $this->compraModel->getProveedores();
        $depositos = $this->compraModel->getDepositos();
        $productos = $this->compraModel->getProductosConUnidad();

        $data = [
            'Title' => 'Registrar Compra',
            'proveedores' => $proveedores,
            'depositos' => $depositos,
            'productos' => $productos
        ];

        View::render('compra/formCompra', $data);
    }

    // Insertar compra
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cod_proveedor = $_POST['cod_proveedor'];
            $nro_factura = $_POST['nro_factura'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $cod_deposito = $_POST['cod_deposito'];
            $total_compra = str_replace('.', '', $_POST['total_compra']);
            $id_user = $_POST['id_user'];
            $productos = $_POST['productos'];
            $cantidades = $_POST['cantidades'];
            $precios = $_POST['precios'];

            try {
                $this->compraModel->conn->beginTransaction();

                // Insertar encabezado
                $cod_compra = $this->compraModel->insertCompra($cod_proveedor, $nro_factura, $fecha, $hora, $cod_deposito, $total_compra, $id_user);

                // Insertar detalle
                for ($i = 0; $i < count($productos); $i++) {
                    $this->compraModel->insertDetalleCompra($cod_compra, $productos[$i], $cod_deposito, $precios[$i], $cantidades[$i]);
                    $this->compraModel->actualizarStock($productos[$i], $cod_deposito, $cantidades[$i]);
                }

                $this->compraModel->conn->commit();
                header("Location: index.php?controller=Compra&action=indexCompra&alert=1");
            } catch (Exception $e) {
                $this->compraModel->conn->rollBack();
                error_log("Error al registrar compra: " . $e->getMessage());
                header("Location: index.php?controller=Compra&action=indexCompra&alert=3");
            }
            exit();
        }
    }

    // Anular compra
    public function anularCompra() {
        if (isset($_GET['id'])) {
            $cod_compra = $_GET['id'];

            try {
                $this->compraModel->conn->beginTransaction();
                $this->compraModel->anularCompra($cod_compra);
                $this->compraModel->conn->commit();

                header("Location: index.php?controller=Compra&action=indexCompra&alert=2");
            } catch (Exception $e) {
                $this->compraModel->conn->rollBack();
                error_log("Error al anular compra: " . $e->getMessage());
                header("Location: index.php?controller=Compra&action=indexCompra&alert=3");
            }
            exit();
        }
    }
}
