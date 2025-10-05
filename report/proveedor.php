<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
        margin: 10px;
    }

    h1 {
        text-align: center;
        font-size: 14pt;
        margin-bottom: 5px;
    }

    .fecha {
        text-align: center;
        font-size: 10pt;
        margin-bottom: 15px;
    }

    table {
        width: 90%;
        border-collapse: collapse;
        margin: auto;
        display: table;
    }

    table th,
    table td {
        font-size: 10pt;
        padding: 4px;
        border: 1px solid #000;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h1>Reporte de Proveedores</h1>

<div class="fecha">
    <p>Fecha: <?= date('d/m/Y') ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Razón Social</th>
            <th>RUC</th>
            <th>Dirección</th>
            <th>Teléfono</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td align="center"><?= htmlspecialchars($row['cod_proveedor']) ?></td>
                <td><?= htmlspecialchars($row['razon_social']) ?></td>
                <td align="center"><?= htmlspecialchars($row['ruc']) ?></td>
                <td><?= htmlspecialchars($row['direccion']) ?></td>
                <td align="center"><?= htmlspecialchars($row['telefono']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
