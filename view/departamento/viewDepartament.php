<section class="content-header">
    <ol class="breadcrumb ">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active"><a href="#">Departamento</a></li>
    </ol>
    <br><br>
    <h1>
        <i class="fa fa-folder icon-title"></i>Datos de Departamentos
        <a class="btn btn-primary bn-social pull-right" href="index.php?controller=Departament&action=indexFormAdd"
            title="Agregar" data-toggle="tooltip"><i class="fa fa-plus"> </i> Agregar</a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            // Lógica de alertas.
            if (isset($_GET['alert'])) {
                $alert = $_GET['alert'];
                $messages = [
                    1 => ['type' => 'success', 'text' => 'Los datos se han registrado correctamente.'],
                    2 => ['type' => 'success', 'text' => 'Los datos se han modificados correctamente.'],
                    3 => ['type' => 'success', 'text' => 'Los datos se han eliminado correctamente.'],
                    4 => ['type' => 'danger', 'text' => 'No se pudo realizar la operación.'],

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

                    <div class="text-right" style="margin-bottom: 10px;">
                        <a class="btn btn-warning" href="index.php?controller=Report&action=reporteDepartamentos" tittle="Generar reporte PDF" data-toggle="tooltip">
                            <i class="fa fa-file-pdf-o"></i> Reporte PDF
                        </a>
                    </div>

                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($departamentos) && is_array($departamentos)) {
                                foreach ($departamentos as $departamento) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($departamento['id_departamento']); ?></td>
                                        <td><?php echo htmlspecialchars($departamento['dep_descripcion']); ?></td>
                                        <td style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                            <a class="btn btn-primary btn-sm"
                                                href="index.php?controller=Departament&action=indexFormEdit&id=<?= htmlspecialchars($departamento['id_departamento']); ?>"
                                                title="Editar">
                                                <i class="glyphicon glyphicon-edit" style="color:#fff"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="index.php?controller=Departament&action=deleteDepartament&id=<?= htmlspecialchars($departamento['id_departamento']); ?>"
                                                onclick="return confirm('¿Estás seguro de eliminar este departamento?');"
                                                title="Eliminar">
                                                <i class="glyphicon glyphicon-trash" style="color:#fff"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="3">No hay departamentos para mostrar.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>