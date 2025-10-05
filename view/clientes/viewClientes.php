<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="#">Clientes</a></li>
    </ol>
    <br><br>
    <h1>
        <i class="fa fa-users icon-title"></i> Datos de Clientes
        <a class="btn btn-primary pull-right"
            href="index.php?controller=Cliente&action=indexFormAdd"
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
                    1 => ['type' => 'success', 'text' => 'Cliente registrado correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Cliente modificado correctamente.'],
                    3 => ['type' => 'success', 'text' => 'Cliente eliminado correctamente.'],
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
                        <a class="btn btn-warning" href="index.php?controller=Report&action=reporteClientes" title="Generar reporte PDF" data-toggle="tooltip">
                            <i class="fa fa-file-pdf-o"></i> Reporte PDF
                        </a>
                    </div>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CI/RUC</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Ciudad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                                        <td><?= htmlspecialchars($cliente['ci_ruc']) ?></td>
                                        <td><?= htmlspecialchars($cliente['cli_nombre']) ?></td>
                                        <td><?= htmlspecialchars($cliente['cli_apellido']) ?></td>
                                        <td><?= htmlspecialchars($cliente['cli_direccion']) ?></td>
                                        <td><?= htmlspecialchars($cliente['cli_telefono']) ?></td>
                                        <td><?= htmlspecialchars($cliente['descrip_ciudad']) ?></td>
                                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                            <a class="btn btn-primary btn-sm"
                                                href="index.php?controller=Cliente&action=indexFormEdit&id=<?= htmlspecialchars($cliente['id_cliente']); ?>"
                                                title="Editar">
                                                <i class="glyphicon glyphicon-edit" style="color:#fff"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="index.php?controller=Cliente&action=delete&id=<?= htmlspecialchars($cliente['id_cliente']); ?>"
                                                onclick="return confirm('¿Seguro que deseas eliminar este cliente?');"
                                                title="Eliminar">
                                                <i class="glyphicon glyphicon-trash" style="color:#fff"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No hay clientes registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
