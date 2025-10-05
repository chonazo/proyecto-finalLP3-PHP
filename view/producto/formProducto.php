<?php
$form_action = isset($producto)
    ? 'index.php?controller=Producto&action=update'
    : 'index.php?controller=Producto&action=insert';

$submit_value = isset($producto) ? 'Editar' : 'Guardar';

$descripcion_value = isset($producto) ? htmlspecialchars($producto['p_descrip']) : '';
$precio_value = isset($producto) ? htmlspecialchars($producto['precio']) : '';
$tipo_selected = isset($producto) ? intval($producto['cod_tipo_prod']) : '';
$unidad_selected = isset($producto) ? intval($producto['id_u_medida']) : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?= $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=Producto&action=indexProducto"> Productos </a></li>
        <li class="active"><?= isset($producto) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?= $form_action; ?>">
                    <div class="box-body">

                        <?php if (isset($producto)): ?>
                            <input type="hidden" name="cod_producto" value="<?= htmlspecialchars($producto['cod_producto']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="p_descrip" autocomplete="off"
                                       value="<?= $descripcion_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tipo de Producto</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="cod_tipo_prod" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?= $tipo['cod_tipo_prod']; ?>"
                                            <?= ($tipo_selected === intval($tipo['cod_tipo_prod'])) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($tipo['t_p_descrip']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Unidad de Medida</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_u_medida" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($unidades as $unidad): ?>
                                        <option value="<?= $unidad['id_u_medida']; ?>"
                                            <?= ($unidad_selected === intval($unidad['id_u_medida'])) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($unidad['u_descrip']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Precio</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="precio" min="0"
                                       value="<?= $precio_value; ?>" required>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" value="<?= $submit_value; ?>">
                                <a href="index.php?controller=Producto&action=indexProducto" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
