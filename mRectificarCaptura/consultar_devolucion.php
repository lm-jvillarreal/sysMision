<?php 
	include '../global_settings/conexion_oracle.php';
	include '../global_settings/conexion.php';
	$sucursal = 1;
	$movimiento = $_POST['tipo_movimiento'];
	$folio = $_POST['folio'];
	$sql = "SELECT
				ROUND( SUM( RMON_COSTO_RENGLON_MB ), 2 ) 
			FROM
				INV_RENGLONES_MOVIMIENTOS 
			WHERE
				MODC_TIPOMOV = '$movimiento' 
				AND MODN_FOLIO = '$folio' 
				AND ALMN_ALMACEN = '$sucursal'";
	$st = oci_parse($conexion_central, $sql);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$array = array(
		$row[0]
	);
	echo json_encode($array);
 ?>