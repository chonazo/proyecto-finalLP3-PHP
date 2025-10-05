<section class="content-header">
    <h1>
        <i class="fa fa-user icon-title"></i> Gestión de Usuarios
        <a class="btn btn-primary btn-social pull-right" href="index.php?controller=Usuarios&action=indexFormAdd" title="Agregar" data-toggle="tooltip">
            <i class="fa fa-plus"></i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['alert'])) {
                $alert = $_GET['alert'];
                $messages = [
                    1 => ['type' => 'success', 'text' => 'Los nuevos datos de usuario se han registrado correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Los datos de usuario han sido cambiados satisfactoriamente.'],
                    3 => ['type' => 'success', 'text' => 'El usuario ha sido activado correctamente.'],
                    4 => ['type' => 'success', 'text' => 'El usuario se bloqueó con éxito.'],
                    5 => ['type' => 'danger', 'text' => 'Hubo un problema con el archivo subido. Asegúrese de que sea correcto.'],
                    6 => ['type' => 'danger', 'text' => 'Asegúrese de que la imagen no sea más de 1 MB.'],
                    7 => ['type' => 'danger', 'text' => 'Asegúrese de que el tipo de archivo sea *.JPG, *.JPEG, *.PNG.'],
                    8 => ['type' => 'danger', 'text' => 'Erroe inesperado. Por favor, intentelo de nuevo.'],
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
                <div class="box-body">
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Foto</th>
                                <th>Nombre de usuario</th>
                                <th>Nombre</th>
                                <th>Permisos de acceso</th>
                                <th>Status</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nro = 1; ?>
                            <?php foreach ($users as $data): ?>
                                <tr>
                                    <td width='50' class='center'><?= $nro ?></td>
                                    <td class='center'>
                                        <?php if (empty($data['foto'])): ?>
                                            <img class='img-user' src='images/user/user-default.png' width='45'>
                                        <?php else: ?>
                                            <img class='img-user' src='images/user/<?= htmlspecialchars($data['foto']) ?>' width='45'>
                                        <?php endif; ?>
                                    </td>
                                    <td class='center'><?= htmlspecialchars($data['username']) ?></td>
                                    <td class='center'><?= htmlspecialchars($data['name_user']) ?></td>
                                    <td class='center'><?= htmlspecialchars($data['permisos_acceso']) ?></td>
                                    <td class='center'>Acción</td>
                                    <td class='center' width='100'>
                                        <div>
                                            <?php if ($data['status'] === 'activo'): ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Bloquear" style="margin-right:5px"
                                                    class="btn btn-warning btn-sm" href="index.php?controller=Usuarios&action=toggleUserStatus&id=<?= $data['id_user'] ?>&act=off">
                                                    <i style="color:#fff" class="glyphicon glyphicon-off"></i>
                                                </a>
                                            <?php else: ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Activar" style="margin-right:5px" 
                                                class="btn btn-success btn-sm" href="index.php?controller=Usuarios&action=toggleUserStatus&id=<?= $data['id_user'] ?>&act=on">
                                                    <i style="color:#fff" class="glyphicon glyphicon-ok"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a data-toggle='tooltip' data-placement='top' title='Modificar' class='btn btn-primary btn-sm' 
                                            href='index.php?controller=Usuarios&action=indexFormEdit&id=<?= $data['id_user'] ?>'>
                                                <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $nro++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>