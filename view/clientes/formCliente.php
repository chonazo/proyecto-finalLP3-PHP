<?php
$form_action = isset($cliente)
    ? 'index.php?controller=Cliente&action=update'
    : 'index.php?controller=Cliente&action=insert';

$submit_value = isset($cliente) ? 'Editar' : 'Guardar';

$ci_ruc_value       = isset($cliente) ? htmlspecialchars($cliente['ci_ruc']) : '';
$cli_nombre_value   = isset($cliente) ? htmlspecialchars($cliente['cli_nombre']) : '';
$cli_apellido_value = isset($cliente) ? htmlspecialchars($cliente['cli_apellido']) : '';
$cli_direccion_value= isset($cliente) ? htmlspecialchars($cliente['cli_direccion']) : '';
$cli_telefono_value = isset($cliente) ? htmlspecialchars($cliente['cli_telefono']) : '';
$cod_ciudad_value   = isset($cliente) ? $cliente['cod_ciudad'] : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?= $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=Cliente&action=indexCliente"> Clientes </a></li>
        <li class="active"><?= isset($cliente) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?= $form_action; ?>">
                    <div class="box-body">

                        <?php if (isset($cliente)): ?>
                            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($cliente['id_cliente']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">CI / RUC</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="ci_ruc" autocomplete="off"
                                       value="<?= $ci_ruc_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="cli_nombre" autocomplete="off"
                                       value="<?= $cli_nombre_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Apellido</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="cli_apellido" autocomplete="off"
                                       value="<?= $cli_apellido_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dirección</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="cli_direccion" autocomplete="off"
                                       value="<?= $cli_direccion_value; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Teléfono</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="cli_telefono" autocomplete="off"
                                       value="<?= $cli_telefono_value; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ciudad</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="cod_ciudad" required>
                                    <option value="">-- Seleccionar Ciudad --</option>
                                    <?php foreach ($ciudades as $ciu): ?>
                                        <option value="<?= htmlspecialchars($ciu['cod_ciudad']); ?>"
                                            <?= $cod_ciudad_value == $ciu['cod_ciudad'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($ciu['descrip_ciudad']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" value="<?= $submit_value; ?>">
                                <a href="index.php?controller=Cliente&action=indexCliente" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
