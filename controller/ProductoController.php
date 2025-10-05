<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/ProductoModel.php';
require_once __DIR__ . '/../model/TipoProductoModel.php';
require_once __DIR__ . '/../model/UnidadMedidaModel.php';

class ProductoController {
    private $productoModel;
    private $tipoProductoModel;
    private $unidadMedidaModel;

    public function __construct(PDO $conn) {
        $this->productoModel = new ProductoModel($conn);
        $this->tipoProductoModel = new TipoProductoModel($conn);
        $this->unidadMedidaModel = new UnidadMedidaModel($conn);
    }

    // Mostrar lista de productos
    public function indexProducto() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $productos = $this->productoModel->getAll();

        $data = [
            'Title' => 'Gestión de Productos',
            'productos' => $productos
        ];

        View::render('producto/viewProducto', $data);
    }

    // Mostrar formulario para agregar producto
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $tipos = $this->tipoProductoModel->getAll();
        $unidades = $this->unidadMedidaModel->getAll();

        $data = [
            'Title' => 'Agregar Producto',
            'producto' => null,
            'tipos' => $tipos,
            'unidades' => $unidades
        ];

        View::render('producto/formProducto', $data);
    }

    // Mostrar formulario para editar producto
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Producto&action=indexProducto&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $producto = $this->productoModel->getById($id);
        $tipos = $this->tipoProductoModel->getAll();
        $unidades = $this->unidadMedidaModel->getAll();

        $data = [
            'Title' => 'Editar Producto',
            'producto' => $producto,
            'tipos' => $tipos,
            'unidades' => $unidades
        ];

        View::render('producto/formProducto', $data);
    }

    // Insertar producto
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $tipo = intval($_POST['cod_tipo_prod']);
            $unidad = intval($_POST['id_u_medida']);
            $descripcion = trim($_POST['p_descrip']);
            $precio = intval($_POST['precio']);

            $result = $this->productoModel->create($tipo, $unidad, $descripcion, $precio);

            if ($result) {
                header("Location: index.php?controller=Producto&action=indexProducto&alert=1");
            } else {
                header("Location: index.php?controller=Producto&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar producto
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['cod_producto']);
            $tipo = intval($_POST['cod_tipo_prod']);
            $unidad = intval($_POST['id_u_medida']);
            $descripcion = trim($_POST['p_descrip']);
            $precio = intval($_POST['precio']);

            $result = $this->productoModel->update($id, $tipo, $unidad, $descripcion, $precio);

            if ($result) {
                header("Location: index.php?controller=Producto&action=indexProducto&alert=2");
            } else {
                header("Location: index.php?controller=Producto&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar producto
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Producto&action=indexProducto&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->productoModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Producto&action=indexProducto&alert=3");
        } else {
            header("Location: index.php?controller=Producto&action=indexProducto&alert=4");
        }
        exit();
    }
}
