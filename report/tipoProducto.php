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

    table th, table td {
        font-size: 14pt;
        padding: 5px;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h1>Reporte de Tipos de Producto</h1>

<div class="fecha">
    <p>Fecha: <?= date('d/m/Y') ?></p>
</div>

<table width="80%" border="1" cellpadding="5" cellspacing="0" align="center">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th align="center" width="100">ID</th>
            <th align="center" width="300">Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td align="center" height="30"><?= htmlspecialchars($row['cod_tipo_prod']) ?></td>
            <td align="left" height="30"><?= htmlspecialchars($row['t_p_descrip']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
