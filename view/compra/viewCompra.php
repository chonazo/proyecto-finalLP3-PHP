<section class="content-header">
    <h1><i class="fa fa-folder-open icon-title"></i> Compras Registradas</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Compras</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php
            // Lógica de alertas.
            if (isset($_GET['alert'])) {
                $alert = $_GET['alert'];
                $messages = [
                    1 => ['type' => 'success', 'text' => 'La compra se han realizado correctamente.'],
                    2 => ['type' => 'success', 'text' => 'La compra se ha anulado y el stock del producto se ha actualizado correctamente.'],
                    3 => ['type' => 'danger', 'text' => 'No se pudo realizar la operación! ocurrió un error inesperado avise al administrador.']

                ];

                if (array_key_exists($alert, $messages)) {
                    $msg_data = $messages[$alert];
                    $alert_class = ($msg_data['type'] === 'success') ? 'alert-success' : 'alert-danger';
                    $icon_class = ($msg_data['type'] === 'success') ? 'fa-check-circle' : 'fa-times-circle';
                    $title_text = ($msg_data['type'] === 'success') ? '¡Éxito!' : '¡Error!';
            ?>
                    <div class="alert <?= $alert_class ?> alert-dismissable">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa <?= $icon_class ?>'></i> <?= $title_text ?></h4>
                        <?= htmlspecialchars($msg_data['text']) ?>
                    </div>
            <?php
                }
            }
            ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <a href="index.php?controller=Compra&action=indexFormAdd" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nueva Compra
                    </a>
                </div>

                <div class="box-body">
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Factura</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Depósito</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($compras) && is_array($compras)): ?>
                                <?php foreach ($compras as $c): ?>
                                    <tr>
                                        <td><?= $c['cod_compra'] ?></td>
                                        <td><?= htmlspecialchars($c['razon_social']) ?></td>
                                        <td><?= htmlspecialchars($c['nro_factura']) ?></td>
                                        <td><?= $c['fecha'] ?></td>
                                        <td><?= $c['hora'] ?></td>
                                        <td><?= htmlspecialchars($c['deposito']) ?></td>
                                        <td><?= number_format($c['total_compra'], 0, ',', '.') ?></td>
                                        <td><?= ucfirst($c['estado']) ?></td>
                                        <td style="display:flex; gap:5px;">
                                            <?php if ($c['estado'] !== 'anulado'): ?>
                                                <!-- Botón para anular compra -->
                                                <a href="index.php?controller=Compra&action=anularCompra&id=<?= $c['cod_compra'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de anular esta compra? Se actualizará el stock.');"
                                                    title="Anular compra">
                                                    <i class="fa fa-ban"></i> Anular
                                                </a>
                                            <?php endif; ?>
                                            <!-- Botón para imprimir PDF -->
                                            <a href="index.php?controller=Report&action=reporteCompraIndividual&id=<?= $c['cod_compra'] ?>"
                                                class="btn btn-warning btn-sm"
                                                title="Imprimir informe PDF">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>