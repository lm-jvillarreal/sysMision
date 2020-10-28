<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	$codigo= $_POST['codigo'];
	$sql_o = "SELECT artc_descripcion FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st = oci_parse($conexion_central, $sql_o);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$array =  array($row[0], $codigo);
	echo json_encode($array);
 ?>