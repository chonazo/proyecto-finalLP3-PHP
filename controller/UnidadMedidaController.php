<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/UnidadMedidaModel.php';

class UnidadMedidaController {
    private $unidadMedidaModel;

    public function __construct(PDO $conn) {
        $this->unidadMedidaModel = new UnidadMedidaModel($conn);
    }

    // Mostrar lista de unidades de medida
    public function indexUnidadMedida() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $unidades_medida = $this->unidadMedidaModel->getAll();

        $data = [
            'Title' => 'Gestión de Unidades de Medida',
            'unidades_medida' => $unidades_medida
        ];

        View::render('unidadMedida/viewUnidadMedida', $data);
    }

    // Mostrar formulario para agregar unidad de medida
    public function indexFormAdd() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title' => 'Agregar Unidad de Medida',
            'unidad_medida' => null
        ];

        View::render('unidadMedida/formUnidadMedida', $data);
    }

    // Mostrar formulario para editar unidad de medida
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $unidad_medida = $this->unidadMedidaModel->getById($id);

        $data = [
            'Title' => 'Editar Unidad de Medida',
            'unidad_medida' => $unidad_medida
        ];

        View::render('unidadMedida/formUnidadMedida', $data);
    }

    // Insertar unidad de medida
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $descripcion = trim($_POST['u_descrip']);

            $result = $this->unidadMedidaModel->create($descripcion);

            if ($result) {
                header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=1");
            } else {
                header("Location: index.php?controller=UnidadMedida&action=indexFormAdd&alert=4");
            }
            exit();
        }
    }

    // Actualizar unidad de medida
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id_user'])) {
                header("Location: index.php?alert=3");
                exit();
            }

            $id = intval($_POST['id_u_medida']);
            $descripcion = trim($_POST['u_descrip']);

            $result = $this->unidadMedidaModel->update($id, $descripcion);

            if ($result) {
                header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=2");
            } else {
                header("Location: index.php?controller=UnidadMedida&action=indexFormEdit&id={$id}&alert=4");
            }
            exit();
        }
    }

    // Eliminar unidad de medida
    public function delete() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=4");
            exit();
        }

        $id = intval($_GET['id']);
        $result = $this->unidadMedidaModel->delete($id);

        if ($result) {
            header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=3");
        } else {
            header("Location: index.php?controller=UnidadMedida&action=indexUnidadMedida&alert=4");
        }
        exit();
    }
}
