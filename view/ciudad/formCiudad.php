<?php
$form_action = isset($ciudad)
    ? 'index.php?controller=Ciudad&action=update'
    : 'index.php?controller=Ciudad&action=insert';

$submit_value = isset($ciudad) ? 'Editar' : 'Guardar';
$descrip_value = isset($ciudad) ? htmlspecialchars($ciudad['descrip_ciudad']) : '';
$id_departamento_value = isset($ciudad) ? $ciudad['id_departamento'] : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?= $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=Ciudad&action=indexCiudad"> Ciudad </a></li>
        <li class="active"><?= isset($ciudad) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?= $form_action; ?>">
                    <div class="box-body">

                        <?php if (isset($ciudad)): ?>
                            <input type="hidden" name="cod_ciudad" value="<?= htmlspecialchars($ciudad['cod_ciudad']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ciudad</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="descrip_ciudad" autocomplete="off" 
                                       value="<?= $descrip_value; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Departamento</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_departamento" required>
                                    <option value="">-- Seleccionar Departamento --</option>
                                    <?php foreach ($departamentos as $dep): ?>
                                        <option value="<?= htmlspecialchars($dep['id_departamento']); ?>" 
                                            <?= $id_departamento_value == $dep['id_departamento'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($dep['dep_descripcion']); ?>
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
                                <a href="index.php?controller=Ciudad&action=indexCiudad" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
