<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$tipo_movimiento = $_POST['tipo_movimiento'];
$folio_mov = $_POST['folio_mov'];
$sucursal = $_POST['sucursal'];

$cadena_consulta = "SELECT modn_folio, modc_tipomov, movd_fechaafectacion, almn_almacen 
					FROM INV_MOVIMIENTOS 
					WHERE MODC_TIPOMOV = '$tipo_movimiento' 
					AND ALMN_ALMACEN = '$sucursal' 
					AND MODN_FOLIO = '$folio_mov'";

$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_movimiento = oci_fetch_row($st);

$cadena_total = "SELECT SUM(ROUND(RMON_COSTO_RENGLON_MB,2))
					FROM inv_renglones_movimientos 
					WHERE almn_almacen = '$sucursal' 
					AND modc_tipomov = '$tipo_movimiento' 
					AND modn_folio = '$folio_mov'";

$st_total = oci_parse($conexion_central, $cadena_total);
oci_execute($st_total);
$row_total = oci_fetch_row($st_total);

$array = array(
	$row_movimiento[0],
	$row_movimiento[1],
	$row_movimiento[2],
	$row_total[0],
	$row_movimiento[3]
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
?>