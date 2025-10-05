<?php
$form_action = isset($unidad_medida)
    ? 'index.php?controller=UnidadMedida&action=update'
    : 'index.php?controller=UnidadMedida&action=insert';

$submit_value = isset($unidad_medida) ? 'Editar' : 'Guardar';
$descripcion_value = isset($unidad_medida) ? htmlspecialchars($unidad_medida['u_descrip']) : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?= $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=UnidadMedida&action=indexUnidadMedida"> Unidad de Medida </a></li>
        <li class="active"><?= isset($unidad_medida) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?= $form_action; ?>">
                    <div class="box-body">

                        <?php if (isset($unidad_medida)): ?>
                            <input type="hidden" name="id_u_medida" value="<?= htmlspecialchars($unidad_medida['id_u_medida']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="u_descrip" autocomplete="off"
                                       value="<?= $descripcion_value; ?>" required>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" value="<?= $submit_value; ?>">
                                <a href="index.php?controller=UnidadMedida&action=indexUnidadMedida" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
