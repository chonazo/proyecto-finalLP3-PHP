<?php
$form_action = isset($proveedor)
    ? 'index.php?controller=Proveedor&action=update'
    : 'index.php?controller=Proveedor&action=insert';

$submit_value = isset($proveedor) ? 'Editar' : 'Guardar';

$razon_social = isset($proveedor) ? htmlspecialchars($proveedor['razon_social']) : '';
$ruc = isset($proveedor) ? htmlspecialchars($proveedor['ruc']) : '';
$direccion = isset($proveedor) ? htmlspecialchars($proveedor['direccion']) : '';
$telefono = isset($proveedor) ? htmlspecialchars($proveedor['telefono']) : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?= $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=Proveedor&action=indexProveedor"> Proveedores </a></li>
        <li class="active"><?= isset($proveedor) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?= $form_action; ?>">
                    <div class="box-body">

                        <?php if (isset($proveedor)): ?>
                            <input type="hidden" name="cod_proveedor" value="<?= htmlspecialchars($proveedor['cod_proveedor']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Razón Social</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="razon_social" autocomplete="off"
                                       value="<?= $razon_social; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">RUC</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="ruc" autocomplete="off"
                                       value="<?= $ruc; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dirección</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="direccion" autocomplete="off"
                                       value="<?= $direccion; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Teléfono</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="telefono" autocomplete="off"
                                       value="<?= $telefono; ?>" required>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" value="<?= $submit_value; ?>">
                                <a href="index.php?controller=Proveedor&action=indexProveedor" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
