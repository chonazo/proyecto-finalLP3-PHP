<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/UsuariosModel.php';


class UsuariosController {
    
    private $usuariosModel;

    public function __construct(PDO $conn) {
        $this->usuariosModel = new UsuariosModel($conn);
    }


    /* Seccion de vistas de usuarios
    =============================================================================
    */

    // Mostrar formulario de cambio de contraseña
    public function indexPass() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = ['Title'  => 'Menú general'];

        View::render('usuarios/changePass', $data);
    }

    // Mostrar view usuarios
    public function indexUser() {

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        // Obtener la lista de usuarios del modelo
        $users = $this->usuariosModel->getAllUsers();

        $data = [
            'Title' => 'Administrar Usuarios',
            'users' => $users
        ];

        View::render('usuarios/user', $data);
    }

    // Mostrar formulario agregar usuario
    public function indexFormAdd() {

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $data = [
            'Title'   => 'Agregar Usuarios',
            'usuario' => null // no hay datos aún
        ];

        View::render('usuarios/user_form', $data);
    }

    // formulario de editar usuario
    public function indexFormEdit() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Usuarios&action=indexUser&alert=9");
            exit();
        }

        $id_user = intval($_GET['id']);
        $usuario = $this->usuariosModel->getById($id_user);

        $data = [
            'Title'   => 'Editar Usuario',
            'usuario' => $usuario
        ];

        View::render('usuarios/user_form', $data);
    }

    // Mostrar perfil de usuarios
    public function indexPerfilUser() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $id_user = $_SESSION['id_user'];
        $usuario = $this->usuariosModel->getById($id_user);

        $data = [
            'Title' => 'Perfil de Usuario',
            'usuario' => $usuario
        ];

        View::render('usuarios/user_perfil', $data);
    }

    /* Seccion de acciones de usuarios
    =============================================================================
    */

    public function updatePass() {

        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Guardar'])) {
            $id_user     = $_SESSION['id_user'];
            $old_pass    = md5(trim($_POST['old_pass']));
            $new_pass    = md5(trim($_POST['new_pass']));
            $retype_pass = md5(trim($_POST['retype_pass']));

            //obtenemos la contraseña actual
            $data = $this->usuariosModel->getPassById($id_user);

            // verificamos la contraseña vieja
            if (!$data || $old_pass !== $data['password']) {
                header("Location: index.php?controller=Usuarios&action=indexPass&alert=1");
                exit();
            }

            // verificamos si coinsiden las contraseñas nuevas y no queden vacíos
            if (empty($_POST['new_pass']) || $new_pass !== $retype_pass) {
                header("Location: index.php?controller=Usuarios&action=indexPass&alert=2");
                exit();
            }

            // si todo esta bien actualizamos la contraseña
            if ($this->usuariosModel->updatePassword($id_user, $new_pass)) {
                header("Location: index.php?controller=Usuarios&action=indexPass&alert=3");
                exit();
            } else {
                header("Location: index.php?controller=Usuarios&action=indexPass&alert=4");
                exit();
            }
        }
    }

    public function toggleUserStatus() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        if (isset($_GET['id']) && isset($_GET['act'])) {
            $id_user = $_GET['id'];
            $new_status = $_GET['act'] == 'on' ? 'activo' : 'bloqueado';

            if ($this->usuariosModel->updateUserStatus($id_user, $new_status)) {
                // Éxito: Redirige con el código de alerta 3 (activar) o 4 (bloquear)
                $alert_code = ($new_status == 'activo') ? 3 : 4;
                header("Location: index.php?controller=Usuarios&action=indexUser&alert=$alert_code");
            } else {
                // Error: Redirige con un código de alerta para error inesperado
                header("Location: index.php?controller=Usuarios&action=indexUser&alert=8");
            }
        }
        exit;
    }

    // Método para manejar la inserción de nuevos usuarios
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recogemos los datos del formulario y los saneamos
            $username = trim($_POST['username']);
            $name_user = trim($_POST['name_user']);
            // Hashing del password con MD5
            $password = md5(trim($_POST['password']));
            $permisos_acceso = $_POST['permisos_acceso'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];

            // Lógica para subir la foto si existe
            $foto = 'user-default.png'; // Valor por defecto
            if (!empty($_FILES['foto']['name'])) {
                $foto_name = $_FILES['foto']['name'];
                $foto_temp = $_FILES['foto']['tmp_name'];
                $path = 'images/user/' . $foto_name;
                move_uploaded_file($foto_temp, $path);
                $foto = $foto_name;
            }

            // Llamamos al método del modelo para insertar al usuario
            $result = $this->usuariosModel->insertUser($username, $password, $name_user, $permisos_acceso, $email, $telefono, $foto);

            if ($result) {
                header("Location: index.php?controller=Usuarios&action=indexUser&alert=1"); // Éxito
            } else {
                header("Location: index.php?controller=Usuarios&action=add&alert=5"); // Error
            }
        }
        exit();
    }

    // Actualización de usuarios existentes
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Guardar'])) {
            $id_user = trim($_POST['id_user']);
            $username = trim($_POST['username']);
            $name_user = trim($_POST['name_user']);
            $email = trim($_POST['email']);
            $telefono = trim($_POST['telefono']);
            $permisos_acceso = trim($_POST['permisos_acceso']);

            // Asignamos null a la nueva foto y contraseña por defecto
            $new_foto = null;
            $new_password = null;

            // Verificar si se subió una nueva foto
            if (!empty($_FILES['foto']['name'])) {
                $foto_temp = $_FILES['foto']['tmp_name'];
                $foto_name = $_FILES['foto']['name'];
                $allowed_extensions = array('jpg', 'jpeg', 'png');
                $extension = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
                $file_size = $_FILES['foto']['size'];

                if (in_array($extension, $allowed_extensions)) {
                    if ($file_size <= 1000000) {
                        $path = 'images/user/' . $foto_name;
                        if (move_uploaded_file($foto_temp, $path)) {
                            $new_foto = $foto_name;
                        } else {
                            // Error al subir archivo
                            header("Location: index.php?controller=Usuarios&action=indexUser&alert=5");
                            exit;
                        }
                    } else {
                        // Tamaño del archivo excedido
                        header("Location: index.php?controller=Usuarios&action=indexUser&alert=6");
                        exit;
                    }
                } else {
                    // Extensión no permitida
                    header("Location: index.php?controller=Usuarios&action=indexUser&alert=7");
                    exit;
                }
            }

            // Verificamos si se proporcionó una nueva contraseña y hashearla
            if (!empty($_POST['password'])) {
                $new_password = md5(trim($_POST['password']));
            }

            // Actualizamos el usuario en el modelo
            $result = $this->usuariosModel->updateUser($id_user, $username, $name_user, $email, $telefono, $permisos_acceso, $new_foto, $new_password);

            if ($result) {
                header("Location: index.php?controller=Usuarios&action=indexUser&alert=2"); // Éxito
            } else {
                header("Location: index.php?controller=Usuarios&action=edit&id=$id_user&alert=8"); // Error
            }
        }
        exit();
    }

    public function modificarPerfil() {
        // 1. Verificación de la solicitud y de la sesión
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['Guardar'])) {
            header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=5");
            exit();
        }

        // 2. Validación de ID del usuario para evitar suplantación
        if (!isset($_SESSION['id_user']) || !isset($_POST['id_user']) || $_SESSION['id_user'] != $_POST['id_user']) {
            header("Location: index.php?alert=3"); // O una alerta de seguridad más específica
            exit();
        }

        // 3. Asignación de variables
        $id_user = intval($_POST['id_user']);
        $username = trim($_POST['username']);
        $name_user = trim($_POST['name_user']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);

        // Obtener la información actual del usuario
        $usuario_actual = $this->usuariosModel->getById($id_user);
        $foto = $usuario_actual['foto'];

        // 4. Lógica de manejo de la foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto_temp = $_FILES['foto']['tmp_name'];
            $foto_name = $_FILES['foto']['name'];
            $foto_size = $_FILES['foto']['size'];

            // Validamos tamaño
            if ($foto_size > 1000000) { // 1 MB
                header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=3");
                exit();
            }

            // Validamos tipo de archivo
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_mime_type = finfo_file($finfo, $foto_temp);
            finfo_close($finfo);

            if (!in_array($file_mime_type, $allowed_mime_types)) {
                header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=4");
                exit();
            }

            // Eliminamos foto antigua si existe
            if (!empty($usuario_actual['foto'])) {
                $old_photo_path = 'images/user/' . $usuario_actual['foto'];
                if (file_exists($old_photo_path) && is_file($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }

            // Generamos un nombre único para la nueva imagen
            $extension = pathinfo($foto_name, PATHINFO_EXTENSION);
            $new_filename = md5(uniqid(rand(), true)) . '.' . $extension;
            $upload_path = 'images/user/' . $new_filename;

            if (move_uploaded_file($foto_temp, $upload_path)) {
                $foto = $new_filename;
            } else {
                header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=2");
                exit();
            }
        }

        // 5. Preparamos los datos y llamar al modelo
        $data_to_update = [
            'id_user' => $id_user,
            'username' => $username,
            'name_user' => $name_user,
            'email' => $email,
            'telefono' => $telefono,
            'foto' => $foto
        ];

        $result = $this->usuariosModel->updateProfile($data_to_update);

        if ($result) {
            header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=1");
        } else {
            header("Location: index.php?controller=Usuarios&action=indexPerfilUser&alert=5");
        }
        exit();
    }
}
