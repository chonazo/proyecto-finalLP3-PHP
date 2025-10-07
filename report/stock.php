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

    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
    }

    table th, table td {
        font-size: 10pt;
        padding: 5px;
        border: 1px solid black;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h1>Reporte de Stock</h1>
<div class="fecha">
    <p>Fecha de emisión: <?= date('d/m/Y') ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Depósito</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['p_descrip']) ?></td>
            <td><?= number_format($row['precio'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['descrip']) ?></td>
            <td><?= $row['cantidad'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
