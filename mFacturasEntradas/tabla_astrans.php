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
            INV_RENGLONES_MOVIMIENTOS.almn_almacen, 
            INV_RENGLONES_MOVIMIENTOS.modc_tipomov, 
            INV_RENGLONES_MOVIMIENTOS.modn_folio,
            INV_RENGLONES_MOVIMIENTOS.rmon_cantsurtida,
            INV_MOVIMIENTOS.MOVD_FECHAAFECTACION,
            INV_TIPOS_MOVIMIENTO.TMOC_DESCRIPCION
        FROM INV_RENGLONES_MOVIMIENTOS 
        INNER JOIN INV_MOVIMIENTOS
        ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO 
        AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
        AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
        INNER JOIN INV_TIPOS_MOVIMIENTO ON INV_TIPOS_MOVIMIENTO.TMOC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
        WHERE 
            INV_MOVIMIENTOS.MODC_TIPOMOV = 'ASTRAN'
        AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ASTRAN'
        AND ARTC_ARTICULO = '$codigo'
        AND
            INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
                TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
            )
        AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
            TO_DATE ('$fecha_final', 'YYYY/MM/DD')
        ) + 1 AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen' AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
                    //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"s\": \"$row_gastos[0]\",
		\"tipo_mov\": \"$row_gastos[5]\",
		\"folio\": \"$row_gastos[2]\",
		\"cantidad\": \"$row_gastos[3]\",
		\"fecha\": \"$row_gastos[4]\"
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