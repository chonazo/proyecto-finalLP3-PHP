<?php
date_default_timezone_set('America/Asuncion');
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');

$form_action = 'index.php?controller=Compra&action=insert';
?>

<section class="content-header">
    <h1><i class="fa fa-edit icon-title"></i> Registrar Compra</h1>
    <ol class="breadcrumb">
        <li><a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?controller=Compra&action=indexCompra"> Compras </a></li>
        <li class="active">Registrar</li>
    </ol>
</section>

<section class="content">
    <form class="form-horizontal" method="POST" action="<?= $form_action; ?>">
        <div class="box box-primary">
            <div class="box-body">

                <!-- Fecha y Hora -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Fecha</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="fecha" value="<?= $fecha_actual; ?>" readonly>
                    </div>
                    <label class="col-sm-1 control-label">Hora</label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control" name="hora" value="<?= $hora_actual; ?>" readonly>
                    </div>
                </div>

                <!-- Proveedor -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Proveedor</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="cod_proveedor" required>
                            <option value="">-- Seleccionar --</option>
                            <?php if (isset($proveedores) && is_array($proveedores)): ?>
                                <?php foreach ($proveedores as $p): ?>
                                    <option value="<?= $p['cod_proveedor']; ?>">
                                        <?= htmlspecialchars($p['razon_social']); ?> | <?= htmlspecialchars($p['ruc']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Nro. Factura -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nro. Factura</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nro_factura" autocomplete="off" required>
                    </div>
                </div>

                <!-- Depósito destino -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Depósito</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="cod_deposito" required>
                            <option value="">-- Seleccionar --</option>
                            <?php if (isset($depositos) && is_array($depositos)): ?>
                                <?php foreach ($depositos as $d): ?>
                                    <option value="<?= $d['cod_deposito']; ?>">
                                        <?= htmlspecialchars($d['descrip']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Estado -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Estado</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="estado" value="pendiente" readonly>
                    </div>
                </div>

                <!-- Usuario -->
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user']; ?>">

            </div>
        </div>

       

        <!-- Modal de productos -->
        <div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 class="modal-title" id="modalProductoLabel">Seleccionar Producto</h4>
                            </div>                            
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Buscador producto-->
                        <div class="form-group row">
                            <label for="buscadorProducto" class="col-sm-3 control-label">Buscar producto:</label>
                            <div class="col-sm-6">
                                <input type="text" id="buscadorProducto" class="form-control input-sm" placeholder="Ej: radio, monitor...">
                            </div>
                        </div>

                        <table class="table table-bordered table-striped" id="tablaProductos">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Unidad</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($productos) && is_array($productos)): ?>
                                    <?php foreach ($productos as $p): ?>
                                        <tr>
                                            <td><?= $p['cod_producto'] ?></td>
                                            <td><?= htmlspecialchars($p['p_descrip']) ?></td>
                                            <td><?= htmlspecialchars($p['unidad_descrip']) ?></td>
                                            <td><?= number_format($p['precio'], 0, ',', '.') ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm agregar-producto"
                                                    data-id="<?= $p['cod_producto'] ?>"
                                                    data-descrip="<?= htmlspecialchars($p['p_descrip']) ?>"
                                                    data-unidad="<?= htmlspecialchars($p['unidad_descrip']) ?>"
                                                    data-precio="<?= $p['precio'] ?>">
                                                    <i class="fa fa-plus"></i> Agregar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla dinámica de productos seleccionados -->
        <div class="box box-primary">
            <div class="box-body">
                 <!-- Botón para abrir el modal -->        
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalProducto">
                    <i class="fa fa-plus"></i> Agregar producto
                </button>
                <br><br>            
                 <table class="table table-bordered" id="tablaDetalle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Campo total y botones finales -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Total Compra</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="total_compra" id="totalCompra" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Compra</button>
                <a href="index.php?controller=Compra&action=indexCompra" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
</section>

<script>
    $(document).ready(function() {
        // Agregar producto desde el modal
        $('.agregar-producto').click(function() {
            const id = $(this).data('id');
            const descrip = $(this).data('descrip');
            const unidad = $(this).data('unidad');
            const precio = parseInt($(this).data('precio'));

            // Evitar duplicados
            if ($('#tablaDetalle input[value="' + id + '"]').length > 0) {
                alert('Este producto ya fue agregado.');
                return;
            }

            const fila = `
            <tr>
                <td>
                    <input type="hidden" name="productos[]" value="${id}">
                    ${descrip}
                </td>
                <td>${unidad}</td>
                <td>
                    <input type="number" name="precios[]" class="form-control precio" value="${precio}" readonly>
                </td>
                <td>
                    <input type="number" name="cantidades[]" class="form-control cantidad" min="1" value="1">
                </td>
                <td class="subtotal">${precio}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm eliminar-fila">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

            $('#tablaDetalle tbody').append(fila);
            $('#modalProducto').modal('hide');
            actualizarTotales();
        });

        // Eliminar fila
        $(document).on('click', '.eliminar-fila', function() {
            $(this).closest('tr').remove();
            actualizarTotales();
        });

        // Recalcular subtotal al cambiar cantidad
        $(document).on('input', '.cantidad', function() {
            const fila = $(this).closest('tr');
            const precio = parseInt(fila.find('.precio').val());
            const cantidad = parseInt($(this).val());

            if (!isNaN(precio) && !isNaN(cantidad)) {
                const subtotal = precio * cantidad;
                fila.find('.subtotal').text(subtotal);
                actualizarTotales();
            }
        });

        // Validar que haya al menos un producto antes de enviar
        $('form').submit(function(e) {
            if ($('#tablaDetalle tbody tr').length === 0) {
                alert('Debe agregar al menos un producto.');
                e.preventDefault();
            }
        });

        // Calcular total general
        function actualizarTotales() {
            let total = 0;
            $('#tablaDetalle tbody tr').each(function() {
                const subtotal = parseInt($(this).find('.subtotal').text());
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            });
            $('#totalCompra').val(total.toLocaleString('es-ES'));
        }
    });

    // Buscador en el modal de productos
    $('#buscadorProducto').on('keyup', function() {
        const valor = $(this).val().toLowerCase();
        $('#tablaProductos tbody tr').each(function() {
            const textoFila = $(this).text().toLowerCase();
            $(this).toggle(textoFila.indexOf(valor) > -1);
        });
    });
</script>