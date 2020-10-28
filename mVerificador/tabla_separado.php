<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$codigo = $_POST['codigo'];
$almacen = $_POST['sucursal'];
//$anio = date("Y");
$anio = '2018';

$cadena = "SELECT
                    PV_SEPARADOS.SEPN_FOLIO,
                    SEPC_CLIENTE,
                    CFG_CLIENTES.CLIC_NOMBRE,
                    TO_CHAR (
                        SEPD_FECHA_ALTA,
                        'YYYY/MM/DD'
                    ),
                    ARSN_CANTIDAD
                FROM
                    PV_SEPARADOS
                INNER JOIN PV_ARTICULOS_SEPARADO ON PV_ARTICULOS_SEPARADO.SEPN_FOLIO = PV_SEPARADOS.SEPN_FOLIO
                AND PV_ARTICULOS_SEPARADO.SEPC_SUCURSAL = PV_SEPARADOS.SEPC_SUCURSAL
                INNER JOIN CFG_CLIENTES ON CFG_CLIENTES.CLIC_CLIENTE = PV_SEPARADOS.SEPC_CLIENTE
                WHERE
                    PV_ARTICULOS_SEPARADO.ARSC_ARTICULO = '$codigo'
                AND PV_SEPARADOS.SEPC_SUCURSAL = '$almacen'
                -- AND PV_SEPARADOS.SEPD_FECHA_ALTA >= TRUNC (
                --     TO_DATE (
                --         '$fecha_inicial',
                --         'YYYY/MM/DD'
                --     )
                -- )
                -- AND PV_SEPARADOS.SEPD_FECHA_ALTA < TRUNC (
                --     TO_DATE (
                --         '$fecha_final',
                --         'YYYY/MM/DD'
                --     )
                -- ) + 1
                AND SEPN_AAAAMMDD_VENTA_FINAL IS NULL
                AND SEPN_USUARIO_CANCELACION IS NULL";
                    //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"folio\": \"$row_gastos[0]\",
		\"cliente\": \"$row_gastos[1]\",
		\"nombre\": \"$row_gastos[2]\",
		\"fecha\": \"$row_gastos[3]\",
		\"cantidad\": \"$row_gastos[4]\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>