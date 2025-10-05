<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/TipoProductoModel.php';

class TipoProductoController {
    private $tipoProductoModel;

    public function __construct(PDO $conn) {
        $this->tipoProductoModel = new TipoProductoModel($conn);
    }

    // Mostrar lista de tipos de producto
    public function indexTipoProducto() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $tipos_producto = $this->tipoProductoModel->getAll();

        $data = [
            'Title' => 'Gestión de Tipos de Producto',
            'tipos_producto' => $tipos_producto
        ];

        View::render('tipoProducto/viewTipoProducto', $data);
    }

    // Mostrar formulario para agregar tipo de producto
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title' => 'Agregar Tipo de Producto',
            'tipo_producto' => null
        ];

        View::render('tipoProducto/formTipoProducto', $data);
    }

    // Mostrar formulario para editar tipo de producto
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $tipo_producto = $this->tipoProductoModel->getById($id);

        $data = [
            'Title' => 'Editar Tipo de Producto',
            'tipo_producto' => $tipo_producto
        ];

        View::render('tipoProducto/formTipoProducto', $data);
    }

    // Insertar tipo de producto
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $descripcion = trim($_POST['t_p_descrip']);

            $result = $this->tipoProductoModel->create($descripcion);

            if ($result) {
                header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=1");
            } else {
                header("Location: index.php?controller=TipoProducto&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar tipo de producto
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['cod_tipo_prod']);
            $descripcion = trim($_POST['t_p_descrip']);

            $result = $this->tipoProductoModel->update($id, $descripcion);

            if ($result) {
                header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=2");
            } else {
                header("Location: index.php?controller=TipoProducto&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar tipo de producto
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->tipoProductoModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=3");
        } else {
            header("Location: index.php?controller=TipoProducto&action=indexTipoProducto&alert=4");
        }
        exit();
    }
}
