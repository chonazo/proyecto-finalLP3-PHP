<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <title>Sysweb - Menú Principal</title>
    <!-- incluimos aquí el archivo de scripts y estilos. -->
    <?php include 'assets/includes/scripts_y_estilos.php'; ?>
</head>

<body class="skin-blue fixed">
    <div class="wrapper">
        <header class="main-header">
            <a href="#" class="logo">
                <img src="assets/img/log.png" alt="Logo SysWeb">
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php echo $topMenu; ?>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <?php echo $sidebarMenu; ?>
            </section>
        </aside>
        <div class="content-wrapper">
            <?php echo $pageContent; ?>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <p style="margin: 0;">Proyecto de LP3 - UTIC - 2do Año | Lic. Análisis de Sistemas Informática</p>               
            </div>
            <strong>Copyright &copy; <?php echo date('Y') ?> <a href="#" target="_blank">Desarrollado por Chono Pesoa</a></strong>
        </footer>
    </div>

    <div class="modal fade" id="logout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-sign-out">Cerrar sesión</i></h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que quieres salir?</p>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" href="index.php?controller=Login&action=logout">Si, salir</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>