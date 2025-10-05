<?php
// Usamos la variable $user que vendrá del controlador
$foto = !empty($user['foto']) ? $user['foto'] : 'user-default.png';
$nombre = htmlspecialchars($user['name_user'] ?? '');
$permisos = htmlspecialchars($user['permisos_acceso'] ?? '');
?>

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="images/user/<?php echo $foto; ?>" class="user-image" alt="Imagen de usuario"/>
        <span class="hidden-xs"><?php echo $nombre; ?><i style="margin-left:5px;" class="fa fa-caret-down"></i></span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header">
            <img src="images/user/<?php echo $foto; ?>" class="img-circle" alt="Imagen de usuario"/>
            <p><?php echo $nombre; ?><small><?php echo $permisos;?></small></p>
        </li>
        <li class="user-footer">
            <div class="pull-left">
                <a style="width:80px" href="index.php?controller=Usuarios&action=indexPerfilUser" class="btn btn-default btn-flat">Perfil</a>
            </div>
            <div class="pull-right">
                <a style="width:80px" href="#" data-toggle="modal" data-target="#logout" class="btn btn-default btn-flat">Salir</a>
            </div>
        </li>
    </ul>
</li>