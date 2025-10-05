<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/ProveedorModel.php';

class ProveedorController {
    private $proveedorModel;

    public function __construct(PDO $conn) {
        $this->proveedorModel = new ProveedorModel($conn);
    }

    // Mostrar lista de proveedores
    public function indexProveedor() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $proveedores = $this->proveedorModel->getAll();

        $data = [
            'Title' => 'Gestión de Proveedores',
            'proveedores' => $proveedores
        ];

        View::render('proveedor/viewProveedor', $data);
    }

    // Mostrar formulario para agregar proveedor
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title' => 'Agregar Proveedor',
            'proveedor' => null
        ];

        View::render('proveedor/formProveedor', $data);
    }

    // Mostrar formulario para editar proveedor
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $proveedor = $this->proveedorModel->getById($id);

        $data = [
            'Title' => 'Editar Proveedor',
            'proveedor' => $proveedor
        ];

        View::render('proveedor/formProveedor', $data);
    }

    // Insertar proveedor
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $razon_social = trim($_POST['razon_social']);
            $ruc = trim($_POST['ruc']);
            $direccion = trim($_POST['direccion']);
            $telefono = trim($_POST['telefono']);

            $result = $this->proveedorModel->create($razon_social, $ruc, $direccion, $telefono);

            if ($result) {
                header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=1");
            } else {
                header("Location: index.php?controller=Proveedor&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar proveedor
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['cod_proveedor']);
            $razon_social = trim($_POST['razon_social']);
            $ruc = trim($_POST['ruc']);
            $direccion = trim($_POST['direccion']);
            $telefono = trim($_POST['telefono']);

            $result = $this->proveedorModel->update($id, $razon_social, $ruc, $direccion, $telefono);

            if ($result) {
                header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=2");
            } else {
                header("Location: index.php?controller=Proveedor&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar proveedor
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->proveedorModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=3");
        } else {
            header("Location: index.php?controller=Proveedor&action=indexProveedor&alert=4");
        }
        exit();
    }
}
