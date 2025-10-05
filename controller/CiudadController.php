<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/CiudadModel.php';
require_once __DIR__ . '/../model/DepartamentModel.php';

class CiudadController {
    private $ciudadModel;
    private $departamentModel;

    public function __construct(PDO $conn) {
        $this->ciudadModel = new CiudadModel($conn);
         $this->departamentModel = new DepartamentModel($conn);
    }

    /* Metodos de vistas de ciudades
    =============================================================================
     */

    //Método para mostrar la vista ciudades
    public function indexCiudad() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $ciudades = $this->ciudadModel->getAll();

        $data = [
            'Title'  => 'Gestion de Ciudades',
            'ciudades' => $ciudades
        ];

        View::render('ciudad/viewCiudad', $data);
    }

    //Metodo para mostrar formulario de agregar departamento
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $departamentos = $this->departamentModel->getAll();

        $data = [
            'Title' => 'Agregar Ciudades',
            'ciudades' => null,
            'departamentos' => $departamentos
            
        ];

        View::render('ciudad/formCiudad', $data);
    }

    // Formulario para editar ciudad
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $ciudad = $this->ciudadModel->getById($id);
        $departamentos = $this->departamentModel->getAll();

        $data = [
            'Title' => 'Editar Ciudad',
            'ciudad' => $ciudad,
            'departamentos' => $departamentos
        ];

        View::render('ciudad/formCiudad', $data);
    }


    /* Métodos de acciones de ciudades
    =============================================================================
     */

    // Insertar ciudad
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $descrip_ciudad = trim($_POST['descrip_ciudad']);
            $id_departamento = intval($_POST['id_departamento']);

            $result = $this->ciudadModel->create($descrip_ciudad, $id_departamento);

            if ($result) {
                header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=1");
            } else {
                header("Location: index.php?controller=Ciudad&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar ciudad
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['cod_ciudad']);
            $descrip_ciudad = trim($_POST['descrip_ciudad']);
            $id_departamento = intval($_POST['id_departamento']);

            $result = $this->ciudadModel->update($id, $descrip_ciudad, $id_departamento);

            if ($result) {
                header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=2");
            } else {
                header("Location: index.php?controller=Ciudad&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar ciudad
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->ciudadModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=3");
        } else {
            header("Location: index.php?controller=Ciudad&action=indexCiudad&alert=4");
        }
        exit();
    }
}