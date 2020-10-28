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
                    INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN,
                    INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV,
                    INV_MOVIMIENTOS.MODN_FOLIO,
                    INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA,
                    RMOC_REFERENCIA
                FROM
                    INV_RENGLONES_MOVIMIENTOS
                INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
                AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
                WHERE
                    ARTC_ARTICULO = '$codigo'
                AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
                    TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
                )
                AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
                    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
                ) + 1
                AND (
                    INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS'
                    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRASE'
                    --OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'

                )
                AND (
                    INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS'
                    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRASE'
                    --OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'
                )
                AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
                AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
                    //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"s\": \"$row_gastos[0]\",
		\"tipo\": \"$row_gastos[1]\",
		\"folio\": \"$row_gastos[2]\",
		\"cantidad\": \"$row_gastos[3]\"
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