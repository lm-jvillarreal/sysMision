<?php 
	include '../global_settings/conexion_oracle.php';
	///////////////////////consulta de informacion///////////////////
	$folio = $_POST['folio'];
	$sucursal = $_POST['sucursal'];
	$movimiento = $_POST['movimiento'];
	$sql = "SELECT
				COUNT( * ) 
			FROM
				INV_MOVIMIENTOS 
			WHERE
				ALMN_ALMACEN = '$sucursal'
				AND MODC_TIPOMOV = '$movimiento' 
				AND MODN_FOLIO = '$folio'";

	
	$st = oci_parse($conexion_central, $sql);
	oci_execute($st);
	$row = oci_fetch_row($st);
	if ($row[0] > 0) {
		echo "true";
	}else{
		echo "false";
	}
 ?>