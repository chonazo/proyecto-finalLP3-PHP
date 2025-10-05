<?php
$form_action = isset($departamento)
    ? 'index.php?controller=Departament&action=update'
    : 'index.php?controller=Departament&action=insert';

$submit_value = isset($departamento) ? 'Editar' : 'Guardar';
$descripcion_value = isset($departamento) ? htmlspecialchars($departamento['dep_descripcion']) : '';
?>

<section class="content-header">
    <h1>
        <i class="fa fa-edit icon-title"></i> <?php echo $Title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio </a></li>
        <li><a href="index.php?controller=Departament&action=indexDepartament"> Departamento </a></li>
        <li class="active"><?php echo isset($departamento) ? 'Modificar' : 'Agregar'; ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form role="form" class="form-horizontal" method="POST" action="<?php echo $form_action; ?>">
                    <div class="box-body">
                        <?php if (isset($departamento)): ?>
                            <input type="hidden" name="id_departamento" value="<?php echo htmlspecialchars($departamento['id_departamento']); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="dep_descripcion" autocomplete="off" value="<?php echo $descripcion_value; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-submit" value="<?php echo $submit_value; ?>">
                                <a href="index.php?controller=Departament&action=indexDepartament" class="btn btn-default btn-reset">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
