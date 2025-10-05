<?php

require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/DepartamentModel.php';


class DepartamentController
{
    private $departamentModel;

    public function __construct(PDO $conn)
    {
        $this->departamentModel = new DepartamentModel($conn);
    }

    /* Metodos de vistas de departamentos
    =============================================================================*/

    //Método para mostrar el vista de lista de departamentos 
    public function indexDepartament() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $departamentos = $this->departamentModel->getAll();

        $data = [
            'Title'  => 'Gestion de Departamentos',
            'departamentos'  => $departamentos
        ];

        View::render('departamento/viewDepartament', $data);
    }

    //Metodo para mostrar formulario de agregar departamento
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title' => 'Agregar Departamento',
            'departamento' => null
        ];

        View::render('departamento/formDepartament', $data);
    }

    // Método para mostrar formulario para editar departamento
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Departament&action=indexDepartament&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $departamento = $this->departamentModel->getById($id);

        $data = [
            'Title'        => 'Editar Departamento',
            'departamento' => $departamento
        ];

        View::render('departamento/formDepartament', $data);
    }

    /* Métodos de acciones de departamentos
    =============================================================================*/

    //Método para insertar departamentos    
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $dep_descripcion = trim($_POST['dep_descripcion']);

            $result = $this->departamentModel->create($dep_descripcion);

            if ($result) {
                // Registro correcto
                header("Location: index.php?controller=Departament&action=indexDepartament&alert=1");
            } else {
                // Error al insertar
                header("Location: index.php?controller=Departament&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Método para editar departamento
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['id_departamento']);
            $dep_descripcion = trim($_POST['dep_descripcion']);

            $result = $this->departamentModel->update($id, $dep_descripcion);

            if ($result) {
                header("Location: index.php?controller=Departament&action=indexDepartament&alert=2");
            } else {
                header("Location: index.php?controller=Departament&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Método para eliminar un departamento
    public function deleteDepartament() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Departament&action=indexDepartament&alert=4");
            exit();
        }

        $id = intval($_GET['id']);

        $result = $this->departamentModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=Departament&action=indexDepartament&alert=3"); // Eliminado con éxito
        } else {
            header("Location: index.php?controller=Departament&action=indexDepartament&alert=4"); // Error
        }
        exit();
    }


}
