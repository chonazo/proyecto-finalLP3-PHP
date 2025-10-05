<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/DepositoModel.php';

class DepositoController {
    private $depositoModel;

    public function __construct(PDO $conn) {
        $this->depositoModel = new DepositoModel($conn);
    }

    // Mostrar lista de depósitos
    public function indexDeposito() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $depositos = $this->depositoModel->getAll();

        $data = [
            'Title' => 'Gestión de Depósitos',
            'depositos' => $depositos
        ];

        View::render('deposito/viewDeposito', $data);
    }

    // Mostrar formulario para agregar depósito
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title' => 'Agregar Depósito',
            'deposito' => null
        ];

        View::render('deposito/formDeposito', $data);
    }

    // Mostrar formulario para editar depósito
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Deposito&action=indexDeposito&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $deposito = $this->depositoModel->getById($id);

        $data = [
            'Title' => 'Editar Depósito',
            'deposito' => $deposito
        ];

        View::render('deposito/formDeposito', $data);
    }

    // Insertar depósito
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $descrip = trim($_POST['descrip']);

            $result = $this->depositoModel->create($descrip);

            if ($result) {
                header("Location: index.php?controller=Deposito&action=indexDeposito&alert=1");
            } else {
                header("Location: index.php?controller=Deposito&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar depósito
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['cod_deposito']);
            $descrip = trim($_POST['descrip']);

            $result = $this->depositoModel->update($id, $descrip);

            if ($result) {
                header("Location: index.php?controller=Deposito&action=indexDeposito&alert=2");
            } else {
                header("Location: index.php?controller=Deposito&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar depósito
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Deposito&action=indexDeposito&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->depositoModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Deposito&action=indexDeposito&alert=3");
        } else {
            header("Location: index.php?controller=Deposito&action=indexDeposito&alert=4");
        }
        exit();
    }
}
