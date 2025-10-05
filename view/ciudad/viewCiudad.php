<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="#">Ciudad</a></li>
    </ol>
    <br><br>
    <h1>
        <i class="fa fa-building icon-title"></i> Datos de Ciudades
        <a class="btn btn-primary pull-right"
            href="index.php?controller=Ciudad&action=indexFormAdd"
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
                    1 => ['type' => 'success', 'text' => 'Ciudad registrada correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Ciudad modificada correctamente.'],
                    3 => ['type' => 'success', 'text' => 'Ciudad eliminada correctamente.'],
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
                        <a class="btn btn-warning" href="index.php?controller=Report&action=reporteCiudades" tittle="Generar reporte PDF" data-toggle="tooltip">
                            <i class="fa fa-file-pdf-o"></i> Reporte PDF
                        </a>
                    </div>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Ciudad</th>
                                <th>Departamento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ciudades)): ?>
                                <?php foreach ($ciudades as $ciudad): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ciudad['cod_ciudad']) ?></td>
                                        <td><?= htmlspecialchars($ciudad['descrip_ciudad']) ?></td>
                                        <td><?= htmlspecialchars($ciudad['dep_descripcion']) ?></td>
                                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                            <a class="btn btn-primary btn-sm"
                                                href="index.php?controller=Ciudad&action=indexFormEdit&id=<?= htmlspecialchars($ciudad['cod_ciudad']); ?>"
                                                title="Editar">
                                                <i class="glyphicon glyphicon-edit" style="color:#fff"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="index.php?controller=Ciudad&action=delete&id=<?= htmlspecialchars($ciudad['cod_ciudad']); ?>"
                                                onclick="return confirm('¿Seguro que deseas eliminar esta ciudad?');"
                                                title="Eliminar">
                                                <i class="glyphicon glyphicon-trash" style="color:#fff"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No hay ciudades registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>