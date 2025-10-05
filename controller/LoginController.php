<?php

require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../lib/EmailHelper.php';
require_once __DIR__ . '/../core/view.php';

class LoginController
{
    private $userModel;

    public function __construct(PDO $conn) {
        $this->userModel = new UserModel($conn);
    }

    public function login() {

        // Evitamos el cacheo de la página de login
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        if (isset($_SESSION['id_user'])) {
            header("Location: index.php?controller=Dashboard&action=index&alert=session_active");
            exit();
        }

        // Si es una petición POST, procesamos el formulario de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                header("Location: index.php?alert=4");
                exit();
            }

            $md5Password = md5($password);
            $data = $this->userModel->authenticate($username, $md5Password);

            if ($data) {
                $_SESSION['alert'] = 'welcome';  //session alert de bienvenida
                // Guardamos estos datos en la session
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['name_user'] = $data['name_user'];
                $_SESSION['permisos_acceso'] = $data['permisos_acceso'];

                header("Location: index.php?controller=Dashboard&action=index");
                exit();
            } else {
                $_SESSION['alert'] = 1; // 1 - para error de login
                header("Location: index.php?alert=1");
                exit();
            }
        }

        // Si no es una petición POST, mostramos el formulario de login y las alertas
        require_once __DIR__ . '/../view/Login.php';
    }

    public function logout() {
        session_unset();
        // Destruimos la sesión por completo.
        session_destroy();

        // Redirigimos al login con el mensaje de éxito.
        header("Location: index.php?controller=Login&action=login&alert=2");
        exit();
    }

    /* Métodos para recuperar contraseña por email
    =============================================================================
    */
    public function sendResetLink() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email)) {
                header("Location: index.php?controller=Login&action=login&alert=4");
                exit();
            }

            $user = $this->userModel->findUserByEmail($email); // correcto

            $alertCode = 5;

            if ($user) {
                // 1. Generar token y tiempo de expiración (1 hora)
                $token = bin2hex(random_bytes(32));
                $expiresAt = date('Y-m-d H:i:s', time() + 3600);

                // 2. Guardar el token en la BD
                $this->userModel->saveResetToken($user['id_user'], $token, $expiresAt);

                // 3. Usar EmailHelper para enviar el correo
                $emailSent = EmailHelper::sendPasswordResetEmail(
                    $user['email'],
                    $user['name_user'],
                    $token
                );

                if (!$emailSent) {
                    // Si el envío falla, usamos 6
                    $alertCode = 6;
                }
            }

            // Redirigimos al login 
            header("Location: index.php?controller=Login&action=login&alert=" . $alertCode);
            exit();
        }

        header("Location: index.php?controller=Login&action=login");
        exit();
    }

    public function showResetForm()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            header("Location: index.php?controller=Login&action=login&alert=7");
            exit();
        }

        // Verifica token y expiración
        $user = $this->userModel->findUserByResetToken($token);

        if (!$user) {
            header("Location: index.php?controller=Login&action=login&alert=8");
            exit();
        }

        View::render('login/reset_password', ['token' => $token]);
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            // El token es esencial, si falta, se asume error de token.
            if (empty($token)) {
                // Error de token faltante. Redirige al login con alerta 7 (Faltante/Inválido)
                header("Location: index.php?controller=Login&action=login&alert=7");
                exit();
            }


            $error_code = null;

            if (empty($password) || empty($passwordConfirm) || strlen($password) < 6) {

                $error_code = 1; // Las contraseñas no coinciden              

                if (empty($password) || empty($passwordConfirm) || strlen($password) < 6) {
                    // Contraseña muy corta o vacía 6 caracteres mínimo.
                    $error_code = 5;
                }
                
            } elseif ($password !== $passwordConfirm) {
                $error_code = 1;
            }

            if ($error_code) {
                // Si hay un error de validación, volvemos a mostrar el formulario con la alerta LOCAL.
                header("Location: index.php?controller=Login&action=showResetForm&token=" . urlencode($token) . "&alert=" . $error_code);
                exit();
            }

            // 2. Volver a validar el token (por seguridad)
            $user = $this->userModel->findUserByResetToken($token);

            if (!$user) {
                // Redirige al LOGIN usando alert 3 invalido/expirado
                header("Location: index.php?controller=Login&action=login&alert=3");
                exit();
            }

            // 3. Hashear la nueva contraseña
            $newHashedPassword = md5($password);

            // 4. Actualizar contraseña y limpiar el token
            $resetSuccess = $this->userModel->resetPassword($user['id_user'], $newHashedPassword);

            if ($resetSuccess) {
                // Redirige al login éxito 
                header("Location: index.php?controller=Login&action=login&alert=9");
                exit();
            } else {
                // Error de DB. Vuelve al formulario con alert 4 (Error al actualizar la contraseña)
                header("Location: index.php?controller=Login&action=showResetForm&token=" . urlencode($token) . "&alert=4");
                exit();
            }
        }
        header("Location: index.php?controller=Login&action=login");
        exit();
    }
}
