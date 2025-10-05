<?php

$form_action = isset($usuario)
    ? 'index.php?controller=Usuarios&action=update'
    : 'index.php?controller=Usuarios&action=insert';

$submit_value = isset($usuario) ? 'Editar' : 'Guardar';
$username_value = isset($usuario) ? htmlspecialchars($usuario['username']) : '';
$name_value = isset($usuario) ? htmlspecialchars($usuario['name_user']) : '';
$email_value = isset($usuario) ? htmlspecialchars($usuario['email']) : '';
$phone_value = isset($usuario) ? htmlspecialchars($usuario['telefono']) : '';
$permissions_value = isset($usuario) ? $usuario['permisos_acceso'] : '';
$password_required = !isset($usuario) ? 'required' : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?php echo $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
        <li><a href="?module=user"> Usuario </a></li>
        <li class="active"><?php echo (isset($user) ? 'Modificar' : 'Agregar'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- El action del formulario es dinámico -->
                <form role="form" class="form-horizontal" method="POST" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php if (isset($user)): ?>
                            <!-- id de usuario -->
                            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($user['id_user']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombre de usuario</label>
                            <div class="col-sm-5">
                                <!-- los campos se llena con los datos del usuario si existen -->
                                <input type="text" class="form-control" name="username" autocomplete="off" value="<?php echo $username_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contraseña</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="password" autocomplete="off" <?php echo $password_required; ?>>
                                <?php if (isset($user)): ?>
                                    <span class="help-block text-red">Dejar en blanco si no quieres cambiar la contraseña.</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_user" autocomplete="off" value="<?php echo $name_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" name="email" autocomplete="off" value="<?php echo $email_value; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Teléfono</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="telefono" autocomplete="off" maxlength="13" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $phone_value; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Foto</label>
                            <div class="col-sm-5">
                                <input type="file" name="foto">
                                <br />
                                <?php if (isset($user) && !empty($user['foto'])): ?>
                                    <img style="border:1px solid #eaeaea;border-radius:5px;" src="images/user/<?php echo htmlspecialchars($user['foto']); ?>" width="128">
                                <?php else: ?>
                                    <img style="border:1px solid #eaeaea;border-radius:5px;" src="images/user/user-default.png" width="128">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Permisos de acceso</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="permisos_acceso" required>
                                    <?php if (!empty($permissions_value)): ?>
                                        <option value="<?php echo htmlspecialchars($permissions_value); ?>"><?php echo htmlspecialchars($permissions_value); ?></option>
                                    <?php endif; ?>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="compras">Compras</option>
                                    <option value="ventas">Ventas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <!-- El valor del botón tambien es dinámico -->
                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="<?php echo $submit_value; ?>">
                                <a href="index.php?controller=Dashboard&action=index" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>