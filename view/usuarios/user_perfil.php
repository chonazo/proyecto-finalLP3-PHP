<?php
$usuario = $data['usuario'] ?? null;
$form_action = 'index.php?controller=Usuarios&action=modificarPerfil';
$submit_value = 'Guardar';
$username_value = isset($usuario) ? htmlspecialchars($usuario['username']) : '';
$name_value = isset($usuario) ? htmlspecialchars($usuario['name_user']) : '';
$email_value = isset($usuario) ? htmlspecialchars($usuario['email']) : '';
$phone_value = isset($usuario) ? htmlspecialchars($usuario['telefono']) : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-user icon.title"> </i> Perfil de Usuarios
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i></a>Inicio
        </li>
        <li class="active"><?php echo $Title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <?php
        // alertas.
        if (isset($_GET['alert'])) {
            $alert = $_GET['alert'];
            $messages = [
                1 => ['type' => 'success', 'text' => 'Los nuevos datos de usuario se han modificado correctamente.'],
                2 => ['type' => 'danger', 'text' => 'Hubo un problema con el archivo subido. Asegúrese de que sea correcto.'],
                3 => ['type' => 'danger', 'text' => 'Asegúrese de que la imagen no sea más de 1 MB.'],
                4 => ['type' => 'danger', 'text' => 'Asegúrese de que el tipo de archivo sea *.JPG, *.JPEG, *.PNG.'],
                5 => ['type' => 'danger', 'text' => 'Error inesperado. Por favor, inténtelo de nuevo.'],
            ];

            if (array_key_exists($alert, $messages)) {
                $msg_data = $messages[$alert];
                $alert_class = ($msg_data['type'] === 'success') ? 'alert-success' : 'alert-danger';
                $icon_class = ($msg_data['type'] === 'success') ? 'fa-check-circle' : 'fa-times-circle';
                $title_text = ($msg_data['type'] === 'success') ? '¡Éxito!' : '¡Error!';
        ?>
                <div class="alert <?= $alert_class ?> alert-dismissable">
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa <?= $icon_class ?>'></i> <?= $title_text ?></h4>
                    <?= htmlspecialchars($msg_data['text']) ?>
                </div>
        <?php
            }
        }
        ?>

        <div class="box box-primary">
            <form role="form" class="form-horizontal" action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <?php if (isset($usuario)): ?>
                        <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($usuario['id_user']); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre de usuario</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="username" autocomplete="off" value="<?php echo $username_value; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre y Apellido</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name_user" autocomplete="off" value="<?php echo $name_value; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" autocomplete="off" value="<?php echo $email_value; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Teléfono</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="telefono" autocomplete="off" value="<?php echo $phone_value; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-5">
                            <input type="file" name="foto">
                            <br />
                            <?php if (isset($usuario) && !empty($usuario['foto'])): ?>
                                <img style="border:1px solid #eaeaea;border-radius:5px;" src="images/user/<?php echo htmlspecialchars($usuario['foto']); ?>" width="128">
                            <?php else: ?>
                                <img style="border:1px solid #eaeaea;border-radius:5px;" src="images/user/user-default.png" width="128">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="<?php echo $submit_value; ?>">
                                <a href="index.php?controller=Usuarios&action=indexPerfilUser" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>