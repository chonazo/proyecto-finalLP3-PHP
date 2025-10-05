<section class="content-header">
    <h1>
        <i class="fa fa-lock icon-title"></i> Cambiar Contraseña
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Administrar usuarios</li>
        <li class="active">Cambiar Contraseña</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Agregar los mensajes de errores-->
            <?php
            if (empty($_GET['alert'])) {
                echo "";
            } elseif ($_GET['alert'] == 1) {
                echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h4> <i class='icon fa fa-times-circle'></i> Error!</h4>
                      La contraseña actual es incorrecta...
                      </div>";
            } elseif ($_GET['alert'] == 2) {
                echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h4> <i class='icon fa fa-times-circle'></i> Error!</h4>
                      La nueva contraseña ingresada no coinciden.
                      </div>";
            } elseif ($_GET['alert'] == 3) {
                echo "<div class='alert alert-success alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h4> <i class='icon fa fa-times-circle'></i> Exitoso!</h4>
                        La nueva contraseña cambiada exitosamente!.
                      </div>";
            } elseif ($_GET['alert'] == 4) {
                echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h4> <i class='icon fa fa-times-circle'></i> Error!</h4>
                      Error inesperado al actualizar avise al administrador...
                      </div>";
            }
            ?>

            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="index.php?controller=Usuarios&action=updatePass">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contraseña antigua</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="old_pass" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contraseña Nueva</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="new_pass" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Repetir nueva contraseña</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="retype_pass" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer bg-btn-action">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>