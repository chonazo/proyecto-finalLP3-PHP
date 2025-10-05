<?php
// assets/includes/scripts_y_estilos.php
// Este archivo copiamos en Main.php contenedor de la plantilla principal
?>

<!-- Hojas de Estilo CSS -->
<link rel="shortcut icon" href="assets/img/favicon.ico" />
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/chosen/css/chosen.min.css" />
<link href="assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datepicker/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />

<!-- Scripts JavaScript -->
<script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/plugins/chosen/js/chosen.jquery.min.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="assets/plugins/slimScroll/jquery.slimscroll.js" type="text/javascript"></script>
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>

<!-- Scripts y configuraciones -->
<script>
    window.onpageshow = function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    };
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        history.go(1);
    };

    function getkey(e) {
        if (window.event)
            return window.event.keyCode;
        else if (e)
            return e.which;
        else
            return null;
    }

    function goodchars(e, goods, field) {
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;
        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();

        if (goods.indexOf(keychar) != -1)
            return true;
        if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
            return true;

        if (key == 13) {
            var i;
            for (i = 0; i < field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        }
        return false;
    }

    $(function() {
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        $('.chosen-select').chosen({
            allow_single_deselect: true
        });
        $(window).off('resize.chosen').on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({
                    'width': $this.parent().width()
                });
            });
        }).trigger('resize.chosen');
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
            if (event_name != 'sidebar_collapsed') return;
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({
                    'width': $this.parent().width()
                });
            });
        });

        $('#chosen-multiple-style .btn').on('click', function(e) {
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
            else $('#form-field-select-4').removeClass('tag-input-style');
        });

        $("#dataTables1").dataTable();
        $('#dataTables2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "language": idioma_español
        });
    });

    var idioma_español = {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    };
</script>