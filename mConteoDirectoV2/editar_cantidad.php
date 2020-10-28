<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	$id = $_POST['id'];
	//$consecutivo = $_POST['consecutivo'];
	//$estante = $_POST['estante'];
	$cantidad = $_POST['cantidad'];
	//$consecutivo = $_POST['consecutivo'];


	$up = "UPDATE inv_captura set cantidad = '$cantidad' WHERE id_detalle_mapeo = '$id'";
	$exUp = mysqli_query($conexion, $up);

	
	
	
	//echo "$sql";
	//$exSql = mysqli_query($conexion, $sql);
 ?>