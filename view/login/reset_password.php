<?php 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/AdminLTE.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body class="hold-transition login-page">
    <div class="container">
        <div class="login-box">
            <div class="login-box-body shadow-lg p-3 mb-5 bg-body rounded">
                <p class="login-box-msg"><i class="fa fa-lock icon-title"></i>Establece tu nueva contraseña</p>
                <hr style="height: 2px; background-color: #1A7595;">

                 <?php
            // Mapeo de los códigos de alerta a mensajes y estilos
            $alertMessages = [
                1 => ['type' => 'danger', 'title' => 'Las contraseñas no coinciden!', 'text' => 'Las contraseñas ingresadas no coinciden. Inténtelo de nuevo'],
                2 => ['type' => 'success', 'title' => 'Éxito contraseña restablecida!', 'text' => 'Contraseña restablecida con éxito. Ya puedes iniciar sesión.'],
                3 => ['type' => 'danger', 'title' => 'Token de recuperación expirado!', 'text' => 'Token expirado o ya utilizado. Por favor, solicite uno nuevo.'],
                4 => ['type' => 'danger', 'title' => 'Error al actualizar la contraseña!', 'text' => 'Error al actualizar la contraseña en la base de datos.'],
                5 => ['type' => 'danger', 'title' => 'Error en la longitud de la contraseña!', 'text' => 'Contraseña muy corta deben ser 6 caracteres mínimo  o vacía.']
            ];

            if (isset($_GET['alert']) && array_key_exists($_GET['alert'], $alertMessages)) {
                $alert = $alertMessages[$_GET['alert']];
                $alert_class = ($alert['type'] === 'success') ? 'alert-success' : 'alert-danger';
                $icon_class = ($alert['type'] === 'success') ? 'fa-exclamation-triangle' : 'fa-times-circle'; 
            ?>
                <div class='alert <?= $alert_class ?>' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h3><i class='icon fa <?= $icon_class ?>'></i> <?= $alert['title'] ?></h3>
                    <p><?= $alert['text'] ?></p>
                </div>
            <?php
            }
            ?>


                <form action="index.php?controller=Login&action=resetPassword" method="post">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"> 

                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Nueva Contraseña" required minlength="6">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <br>
                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirm" class="form-control" placeholder="Confirmar Contraseña" required minlength="6">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                <i class="fa fa-check"></i> Cambiar Contraseña
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>