<?php
// Usamos la variable $user que viene del controlador
$permisos = htmlspecialchars($user['permisos_acceso'] ?? '');
$currentController = $_GET['controller'] ?? 'Dashboard';
$currentAction = $_GET['action'] ?? 'index';
?>
<ul class="sidebar-menu">
    <li class="header">Menu</li>

    <?php $active_home = ($currentController == 'Dashboard' && $currentAction == 'index') ? 'active' : ''; ?>
    <li class="<?= $active_home ?>">
        <a href="index.php?controller=Dashboard&action=index"><i class="fa fa-home"></i>Inicio</a>
    </li>

    <?php if ($permisos == "super_admin"): ?>

        <?php
        // Lógica para activar el menú "Referenciales generales"
        $active_generales = ($currentController == 'Departamento' || $currentController == 'Ciudad') ? 'active menu-open' : '';
        ?>
        <li class="treeview <?= $active_generales ?>">
            <a href="#">
                <i class="fa fa-car" aria-hidden="true"></i><span>Referenciales generales</span><i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="<?= ($currentController == 'Departamento') ? 'active' : '' ?>"><a href="index.php?controller=Departament&action=indexDepartament"><i class="fa fa-circle-o"></i>Departamento</a></li>
                <li class="<?= ($currentController == 'Ciudad') ? 'active' : '' ?>"><a href="index.php?controller=Ciudad&action=indexCiudad"><i class="fa fa-circle-o"></i>Ciudad</a></li>
            </ul>
        </li>

        <?php
        // Lógica para activar el menú "Referenciales Compras"
        $active_compras = ($currentController == 'Deposito' || $currentController == 'Proveedor' || $currentController == 'Producto' || $currentController == 'UnidadMedidas') ? 'active menu-open' : '';
        ?>
        <li class="treeview <?= $active_compras ?>">
            <a href="#">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i></i> <span>Referenciales Compras</span><i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="<?= ($currentController == 'Deposito') ? 'active' : '' ?>"><a href="index.php?controller=Deposito&action=indexDeposito"><i class="fa fa-circle-o"></i>Depósito</a></li>
                <li class="<?= ($currentController == 'Proveedor') ? 'active' : '' ?>"><a href="index.php?controller=Proveedor&action=indexProveedor"><i class="fa fa-circle-o"></i>Proveedor</a></li>
                <li class="<?= ($currentController == 'Producto') ? 'active' : '' ?>"><a href="index.php?controller=Producto&action=indexProducto"><i class="fa fa-circle-o"></i>Producto</a></li>
                <li class="<?= ($currentController == 'UnidadMedidas') ? 'active' : '' ?>"><a href="index.php?controller=UnidadMedida&action=indexUnidadMedida"><i class="fa fa-circle-o"></i>Unidad de Medidas</a></li>
                <li class="<?= ($currentController == 'TipoProductos') ? 'active' : '' ?>"><a href="index.php?controller=TipoProducto&action=indexTipoProducto"><i class="fa fa-circle-o"></i>Tipo de Productos</a></li>
            </ul>
        </li>

        <?php
        // Lógica para activar el menú "Referenciales Ventas"
        $active_ventas = ($currentController == 'Clientes') ? 'active menu-open' : '';
        ?>
        <li class="treeview <?= $active_ventas ?>">
            <a href="#">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>Referenciales Ventas</span><i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="<?= ($currentController == 'Clientes') ? 'active' : '' ?>"><a href="index.php?controller=Cliente&action=indexCliente"><i class="fa fa-circle-o"></i>Clientes</a></li>
            </ul>
        </li>

        <?php
        $active_usuarios = ($currentController == 'Usuarios' && $currentAction == 'index') ? 'active' : '';
        ?>
        <li class="<?= $active_usuarios ?>">
            <a href="index.php?controller=Usuarios&action=indexUser"><i class="fa fa-user"></i>Administrar Usuarios</a>
        </li>
        
        <?php
        $active_password = ($currentController == 'Usuarios' && $currentAction == 'CambiarContrasena') ? 'active' : '';
        ?>
        <li class="<?= $active_password ?>">
            <a href="index.php?controller=Usuarios&action=indexPass"><i class="fa fa-key"></i>Cambiar Contraseña</a>
        </li>

    <?php endif; ?>
    
    <?php if ($permisos == "otro_rol"): ?>
    
    <?php endif; ?>
</ul>