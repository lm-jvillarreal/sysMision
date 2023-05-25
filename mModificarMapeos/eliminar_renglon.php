<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	// include '../global_settings/conexion_pruebas.php';
	// include '../global_settings/conexion_oracle.php';
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$qry = "DELETE FROM inv_detalle_mapeo WHERE id = $id";
	
	//echo "$sql";
	$exSql = mysqli_query($conexion, $qry);
 ?>