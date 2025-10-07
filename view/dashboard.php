<?php
// Zona horaria y bienvenida
date_default_timezone_set('America/Asuncion');
$rol = $_SESSION['permisos_acceso'] ?? '';
$name_user = htmlspecialchars($_SESSION['name_user'] ?? '');
?>

<section class="content-header">
    <h1><i class="fa fa-home icon-title"></i> Inicio</h1>
    <ol class="breadcrumb">
        <li><a href="?controller=Dashboard&action=index"><i class="fa fa-home"></i> Inicio</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <?php if (isset($_SESSION['alert']) && $_SESSION['alert'] == 'welcome'): ?>
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p style="font-size:15px">
                        <i class="icon fa fa-user"></i> Bienvenido/a <strong><?= $name_user ?></strong> a la aplicación: <strong>SysWeb</strong>
                    </p>
                </div>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
    </div>

    <h2>Accesos rápidos</h2>
    <div class="row">

        <?php if (in_array($rol, ['super_admin', 'comprador'])): ?>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Compras</h3>
                    <p>Registrar la compra de productos</p>
                </div>
                <div class="icon"><i class="glyphicon glyphicon-piggy-bank"></i></div>
                <a href="index.php?controller=Compra&action=indexCompra" class="small-box-footer">
                    Ir a Compras <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if (in_array($rol, ['super_admin', 'vendedor'])): ?>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Ventas</h3>
                    <p>Registrar ventas de productos</p>
                </div>
                <div class="icon"><i class="fa fa-cart-plus"></i></div>
                <a href="index.php?controller=Venta&action=indexVenta" class="small-box-footer">
                    Ir a Ventas <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if (in_array($rol, ['super_admin', 'vendedor', 'comprador'])): ?>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Stock</h3>
                    <p>Visualizar stock de productos</p>
                </div>
                <div class="icon"><i class="fa fa-area-chart"></i></div>
                <a href="index.php?controller=Stock&action=indexStock" class="small-box-footer">
                    Ir a Stock <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
