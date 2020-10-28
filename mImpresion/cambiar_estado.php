<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	// include '../global_settings/conexion_pruebas.php';
	// include '../global_settings/conexion_oracle.php';
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$qry = "UPDATE inv_mapeo SET impreso = 1, imprime = $id_usuario WHERE id = $id";
	
	//echo "$sql";
	$exSql = mysqli_query($conexion, $qry);
 ?>