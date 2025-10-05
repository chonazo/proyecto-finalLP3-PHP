<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/CiudadModel.php';
require_once __DIR__ . '/../model/ClienteModel.php';

class ClienteController {
    private $clienteModel;
    private $ciudadModel;

    public function __construct(PDO $conn){
        $this->clienteModel = new ClienteModel($conn);
        $this->ciudadModel = new CiudadModel($conn);
    }

    /* Métodos de vistas de clientes
    ==============================================================================
    */

    // Mostrar lista de clientes
    public function indexCliente() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $clientes = $this->clienteModel->getAll();
        $data = [
            'Title'  => 'Gestion de clientes',
            'clientes' => $clientes
        ];

        View::render('clientes/viewClientes', $data);
    }

    // Mostrar formulario para agregar cliente
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $ciudades = $this->ciudadModel->getAll();

        $data = [
            'Title' => 'Agregar Cliente',
            'cliente' => null,
            'ciudades' => $ciudades
        ];

        View::render('clientes/formCliente', $data);
    }

    // Mostrar formulario para editar cliente
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Cliente&action=indexCliente&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $cliente = $this->clienteModel->getById($id);
        $ciudades = $this->ciudadModel->getAll();

        $data = [
            'Title' => 'Editar Cliente',
            'cliente' => $cliente,
            'ciudades' => $ciudades
        ];

        View::render('clientes/formCliente', $data);
    }

    /* Métodos crud de clientes
    ==============================================================================
    */

    // Insertar cliente
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $ci_ruc = trim($_POST['ci_ruc']);
            $cli_nombre = trim($_POST['cli_nombre']);
            $cli_apellido = trim($_POST['cli_apellido']);
            $cli_direccion = trim($_POST['cli_direccion']);
            $cli_telefono = trim($_POST['cli_telefono']);
            $cod_ciudad = intval($_POST['cod_ciudad']);

            $result = $this->clienteModel->create($ci_ruc, $cli_nombre, $cli_apellido, $cli_direccion, $cli_telefono, $cod_ciudad);

            if ($result) {
                header("Location: index.php?controller=Cliente&action=indexCliente&alert=1");
            } else {
                header("Location: index.php?controller=Cliente&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar cliente
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['id_cliente']);
            $ci_ruc = trim($_POST['ci_ruc']);
            $cli_nombre = trim($_POST['cli_nombre']);
            $cli_apellido = trim($_POST['cli_apellido']);
            $cli_direccion = trim($_POST['cli_direccion']);
            $cli_telefono = trim($_POST['cli_telefono']);
            $cod_ciudad = intval($_POST['cod_ciudad']);

            $result = $this->clienteModel->update($id, $ci_ruc, $cli_nombre, $cli_apellido, $cli_direccion, $cli_telefono, $cod_ciudad);

            if ($result) {
                header("Location: index.php?controller=Cliente&action=indexCliente&alert=2");
            } else {
                header("Location: index.php?controller=Cliente&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar cliente
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Cliente&action=indexCliente&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->clienteModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Cliente&action=indexCliente&alert=3");
        } else {
            header("Location: index.php?controller=Cliente&action=indexCliente&alert=4");
        }
        exit();
    }
}