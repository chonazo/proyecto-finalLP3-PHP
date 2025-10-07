<?php
require __DIR__ . '/../assets/plugins/vendor/autoload.php';
require_once __DIR__ . '/../model/ReportModel.php';

use Spipu\Html2Pdf\Html2Pdf;

class ReportController {
    private $reportModel;

    public function __construct($conn) {
        $this->reportModel = new ReportModel($conn);
    }

    // --- Reporte Departamentos ---
    public function reporteDepartamentos() {
        $sql = "SELECT id_departamento, dep_descripcion FROM sysweb.departamento";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/departamentos.php';
        $filename = 'reporte_departamentos.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Ciudades ---
    public function reporteCiudades() {
        $sql = "SELECT c.cod_ciudad, c.descrip_ciudad, d.dep_descripcion
                FROM ciudad c
                JOIN departamento d ON c.id_departamento = d.id_departamento";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/ciudades.php';
        $filename = 'reporte_ciudades.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Clientes ---
    public function reporteClientes() {
        $sql = "SELECT cl.id_cliente, cl.ci_ruc, cl.cli_nombre, cl.cli_apellido, 
                cl.cli_direccion, cl.cli_telefono, ci.descrip_ciudad
                FROM clientes cl LEFT JOIN ciudad ci ON cl.cod_ciudad = ci.cod_ciudad";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/clientes.php';
        $filename = 'reporte_clientes.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Deposito ---
    public function reporteDepositos() {
        $sql = "SELECT cod_deposito, descrip FROM deposito";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/deposito.php';
        $filename = 'reporte_deposito.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Tipo de Producto ---
    public function reporteTipoProducto() {
        $sql = "SELECT cod_tipo_prod, t_p_descrip FROM tipo_producto";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/tipoProducto.php';
        $filename = 'reporte_tipo_producto.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Unidad de Medida ---
    public function reporteUnidadMedida() {
        $sql = "SELECT id_u_medida, u_descrip FROM sysweb.u_medida";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/unidadMedida.php';
        $filename = 'reporte_unidad_medida.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Producto ---
    public function reporteProducto() {
        $sql = "SELECT p.cod_producto, p.p_descrip, p.precio, tp.t_p_descrip AS tipo_descrip,
                    um.u_descrip AS unidad_descrip FROM producto p
                JOIN tipo_producto tp ON p.cod_tipo_prod = tp.cod_tipo_prod
                JOIN u_medida um ON p.id_u_medida = um.id_u_medida";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/producto.php';
        $filename = 'reporte_producto.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Proveedor ---
    public function reporteProveedor() {
        $sql = "SELECT cod_proveedor, razon_social, ruc, direccion, telefono FROM proveedor";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/proveedor.php';
        $filename = 'reporte_proveedor.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte stock ---
    public function reporteStock() {
        $sql = "SELECT p.p_descrip, p.precio, d.descrip, s.cantidad
        FROM stock s
        INNER JOIN producto p ON s.cod_producto = p.cod_producto
        INNER JOIN deposito d ON s.cod_deposito = d.cod_deposito";
        $data = $this->reportModel->getData($sql);
        $view = __DIR__ . '/../report/stock.php';
        $filename = 'reporte_stock.pdf';

        $this->generarPDF($view, $data, $filename);
    }

    // --- Reporte Compra ---
    public function reporteCompraIndividual() {
        if (isset($_GET['id'])) {
            $cod_compra = $_GET['id'];

            // Consulta de cabecera
            $sqlCabecera = "SELECT comp.cod_compra, prov.cod_proveedor, prov.razon_social,
                        dep.cod_deposito, dep.descrip AS deposito, comp.nro_factura,
                        comp.fecha, comp.hora, comp.total_compra, usu.id_user, usu.name_user
                        FROM compra comp 
                        INNER JOIN proveedor prov ON comp.cod_proveedor = prov.cod_proveedor
                        INNER JOIN deposito dep ON comp.cod_deposito = dep.cod_deposito
                        INNER JOIN usuarios usu ON comp.id_user = usu.id_user
                        WHERE comp.cod_compra = :cod_compra";

            // Consulta de detalle
            $sqlDetalle = "SELECT pro.cod_producto, pro.p_descrip, tpro.t_p_descrip,
                       um.u_descrip, det.precio, det.cantidad
                       FROM detalle_compra det
                       INNER JOIN producto pro ON det.cod_producto = pro.cod_producto
                       INNER JOIN tipo_producto tpro ON pro.cod_tipo_prod = tpro.cod_tipo_prod
                       INNER JOIN u_medida um ON pro.id_u_medida = um.id_u_medida
                       WHERE det.cod_compra = :cod_compra";

            // Obtener datos
            $cabecera = $this->reportModel->getData($sqlCabecera, [':cod_compra' => $cod_compra]);
            $detalle = $this->reportModel->getData($sqlDetalle, [':cod_compra' => $cod_compra]);

            // Enviar a la vista
            $data = ['cabecera' => $cabecera[0], 'detalle' => $detalle];
            $view = __DIR__ . '/../report/compraIndividual.php';
            $filename = 'reporte_compra_' . $cod_compra . '.pdf';

            $this->generarPDF($view, $data, $filename);
        }
    }


    // --- Método común que renderiza el PDF ---
    private function generarPDF($view, $data, $filename) {
        ob_start();
        include $view;
        $html = ob_get_clean();

        try {
            $pdf = new Html2Pdf('P', 'A4', 'es');
            $pdf->writeHTML($html);
            $pdf->output($filename, 'D'); // descarga directa
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
