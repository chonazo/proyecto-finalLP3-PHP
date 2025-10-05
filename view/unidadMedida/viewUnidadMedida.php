<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="#">Unidad de Medida</a></li>
    </ol>
    <br><br>
    <h1>
        <i class="fa fa-balance-scale icon-title"></i> Datos de Unidad de Medida
        <a class="btn btn-primary pull-right"
            href="index.php?controller=UnidadMedida&action=indexFormAdd"
            title="Agregar" data-toggle="tooltip">
            <i class="fa fa-plus"> </i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['alert'])) {
                $messages = [
                    1 => ['type' => 'success', 'text' => 'Unidad de medida registrada correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Unidad de medida modificada correctamente.'],
                    3 => ['type' => 'success', 'text' => 'Unidad de medida eliminada correctamente.'],
                    4 => ['type' => 'danger',  'text' => 'Error en la operación.']
                ];

                if (array_key_exists($_GET['alert'], $messages)) {
                    $msg = $messages[$_GET['alert']];
                    $class = ($msg['type'] === 'success') ? 'alert-success' : 'alert-danger';
                    $icon  = ($msg['type'] === 'success') ? 'fa-check-circle' : 'fa-times-circle';
                    $title = ($msg['type'] === 'success') ? '¡Éxito!' : '¡Error!';
            ?>
                    <div class="alert <?= $class ?> alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4><i class="icon fa <?= $icon ?>"></i> <?= $title ?></h4>
                        <?= htmlspecialchars($msg['text']) ?>
                    </div>
            <?php }
            } ?>

            <div class="box box-primary">
                <div class="box-body">
                    <div class="text-right" style="margin-bottom: 10px;">
                        <a class="btn btn-warning" href="index.php?controller=Report&action=reporteUnidadMedida" title="Generar reporte PDF" data-toggle="tooltip">
                            <i class="fa fa-file-pdf-o"></i> Reporte PDF
                        </a>
                    </div>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($unidades_medida)): ?>
                                <?php foreach ($unidades_medida as $unidad): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($unidad['id_u_medida']) ?></td>
                                        <td><?= htmlspecialchars($unidad['u_descrip']) ?></td>
                                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                            <a class="btn btn-primary btn-sm"
                                                href="index.php?controller=UnidadMedida&action=indexFormEdit&id=<?= htmlspecialchars($unidad['id_u_medida']); ?>"
                                                title="Editar">
                                                <i class="glyphicon glyphicon-edit" style="color:#fff"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="index.php?controller=UnidadMedida&action=delete&id=<?= htmlspecialchars($unidad['id_u_medida']); ?>"
                                                onclick="return confirm('¿Seguro que deseas eliminar esta unidad de medida?');"
                                                title="Eliminar">
                                                <i class="glyphicon glyphicon-trash" style="color:#fff"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No hay unidades de medida registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>