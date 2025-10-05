<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="#">Tipo de Producto</a></li>
    </ol>
    <br><br>
    <h1>
        <i class="fa fa-tags icon-title"></i> Datos de Tipo de Producto
        <a class="btn btn-primary pull-right"
            href="index.php?controller=TipoProducto&action=indexFormAdd"
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
                    1 => ['type' => 'success', 'text' => 'Tipo de producto registrado correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Tipo de producto modificado correctamente.'],
                    3 => ['type' => 'success', 'text' => 'Tipo de producto eliminado correctamente.'],
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
                        <a class="btn btn-warning" href="index.php?controller=Report&action=reporteTipoProducto" title="Generar reporte PDF" data-toggle="tooltip">
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
                            <?php if (!empty($tipos_producto)): ?>
                                <?php foreach ($tipos_producto as $tipo): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($tipo['cod_tipo_prod']) ?></td>
                                        <td><?= htmlspecialchars($tipo['t_p_descrip']) ?></td>
                                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                            <a class="btn btn-primary btn-sm"
                                                href="index.php?controller=TipoProducto&action=indexFormEdit&id=<?= htmlspecialchars($tipo['cod_tipo_prod']); ?>"
                                                title="Editar">
                                                <i class="glyphicon glyphicon-edit" style="color:#fff"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="index.php?controller=TipoProducto&action=delete&id=<?= htmlspecialchars($tipo['cod_tipo_prod']); ?>"
                                                onclick="return confirm('¿Seguro que deseas eliminar este tipo de producto?');"
                                                title="Eliminar">
                                                <i class="glyphicon glyphicon-trash" style="color:#fff"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No hay tipos de producto registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>