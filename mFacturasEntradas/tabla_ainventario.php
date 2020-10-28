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
          INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO,
          INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV,
          RMON_CANTSURTIDA,
          ALMN_ALMACENDESTINO,
          TO_CHAR (
            INV_MOVIMIENTOS.MOVD_FECHAAFECTACION,
            'YYYY/MM/DD'
          ),
          MOVN_USUARIOREALIZAMOV
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
          INV_MOVIMIENTOS.MODC_TIPOMOV = 'ETRANS'
          OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTTRA'
        )
        AND (
          INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ETRANS'
          OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTTRA'
        )
        AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
                    //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"s\": \"$row_gastos[5]\",
		\"folio\": \"$row_gastos[0]\",
		\"tipo\": \"$row_gastos[6]\",
		\"fecha\": \"$row_gastos[3]\",
		\"cantidad\": \"$row_gastos[2]\",
    \"usuario\": \"$row_gastos[4]\"
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