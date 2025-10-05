<section class="content-header">
    <h1>
        <i class="fa fa-home icon-title"></i> Inicio
    </h1>
    <ol class="breadcrumb">
        <li><a href="?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <?php
if (isset($_SESSION['alert']) && $_SESSION['alert'] == 'welcome') {
    ?>
    <div class="col-lg-12 col-xs-12">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p style="font-size:15px">
                <i class="icon fa fa-user"></i> Bienvenido/a 
                <strong><?= htmlspecialchars($user['name_user'] ?? '') ?></strong>
                a la aplicación: <strong>SysWeb</strong>
            </p>
        </div>
    </div>
    <?php
    unset($_SESSION['alert']);
}
?>

    </div>

    <?php
    $permisos = htmlspecialchars($user['permisos_acceso'] ?? '');
    $bloques = [
        ['titulo' => 'Compras', 'color' => '#00c0ef', 'icon' => 'glyphicon glyphicon-piggy-bank', 'controller' => 'Compras', 'descripcion' => ['Registrar', 'la Compra', 'de Productos']],
        ['titulo' => 'Ventas', 'color' => '#00a65a', 'icon' => 'fa fa-cart-plus', 'controller' => 'Ventas', 'descripcion' => ['Registrar', 'Ventas', 'de Productos']],
        ['titulo' => 'Stock', 'color' => '#f39c12', 'icon' => 'fa fa-area-chart', 'controller' => 'Stock', 'descripcion' => ['Visualizar', 'Stock', 'de Productos']],
    ];
    ?>

    <?php if ($permisos == 'super_admin'): ?>
        <h2>Formulario de movimiento</h2>
        <div class="row">
            <?php foreach ($bloques as $b): ?>
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="small-box" style="background-color: <?= $b['color']; ?>; color:#fff;">
                        <div class="inner">
                            <p><strong><?= $b['titulo']; ?></strong></p>
                            <ul style="margin:0; padding-left:20px;">
                                <?php foreach ($b['descripcion'] as $desc): ?>
                                    <li><?= $desc; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="icon"><i class="<?= $b['icon']; ?>"></i></div>
                        <a href="index.php?controller=<?= $b['controller']; ?>&action=index" class="small-box-footer" title="Acceder"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>