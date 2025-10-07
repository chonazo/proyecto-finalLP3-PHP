<?php
$cabecera = $data['cabecera'];
$detalles = $data['detalle'];
?>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12pt;
        margin: 10px;
    }

    h1 {
        text-align: center;
        font-size: 18pt;
        margin-bottom: 5px;
    }

    .fecha {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 20px;
    }

    /* Cabecera sin bordes */
    table.cabecera {
        width: 60%;
        margin: auto;
        border-collapse: collapse;
    }

    table.cabecera td {
        font-size: 10pt;
        padding: 3px;
        border: none;
    }

    /* Tabla de detalle con bordes */
    table.content {
        width: 60%;
        margin: auto;
        border-collapse: collapse;
        border: 1px solid black;
    }

    table.content th,
    table.content td {
        font-size: 10pt;
        padding: 3px;
        border: 1px solid black;
    }

    table.content th {
        background-color: #f2f2f2;
    }

    table.content tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h1>Informe de Compra Nº <?= $cabecera['cod_compra'] ?></h1>

<div class="fecha">
    <p>Fecha de emisión: <?= date('d/m/Y') ?></p>
</div>

<table class="cabecera">
    <tbody>
        <tr>
            <td><strong>Proveedor:</strong> <?= htmlspecialchars($cabecera['razon_social']) ?></td>
            <td><strong>Factura:</strong> <?= htmlspecialchars($cabecera['nro_factura']) ?></td>
        </tr>
        <tr>
            <td><strong>Depósito:</strong> <?= htmlspecialchars($cabecera['deposito']) ?></td>
            <td><strong>Fecha:</strong> <?= $cabecera['fecha'] ?> <?= $cabecera['hora'] ?></td>
        </tr>
        <tr>
            <td><strong>Usuario:</strong> <?= htmlspecialchars($cabecera['name_user']) ?></td>
            <td><strong>Total:</strong> <?= number_format($cabecera['total_compra'], 0, ',', '.') ?></td>
        </tr>
    </tbody>
</table>

<br>
<h3 style="text-align:center;">Detalle de Productos</h3>

<table class="content">
    <thead>
        <tr>
            <th align="center">Código</th>
            <th align="left">Descripción</th>
            <th align="left">Tipo</th>
            <th align="center">Unidad</th>
            <th align="center">Precio</th>
            <th align="center">Cantidad</th>
            <th align="center">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detalles as $d): ?>
        <tr>
            <td align="center"><?= $d['cod_producto'] ?></td>
            <td align="left"><?= htmlspecialchars($d['p_descrip']) ?></td>
            <td align="left"><?= $d['t_p_descrip'] ?></td>
            <td align="center"><?= $d['u_descrip'] ?></td>
            <td align="center"><?= number_format($d['precio'], 0, ',', '.') ?></td>
            <td align="center"><?= $d['cantidad'] ?></td>
            <td align="center"><?= number_format($d['precio'] * $d['cantidad'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
