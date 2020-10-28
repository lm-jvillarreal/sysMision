<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_supsys.php';
	$id_caja = $_POST['id_caja'];
	$codigo = $_POST['codigo'];
	$cantidad = $_POST['cantidad'];
	$descripcion = $_POST['descripcion'];
	$sql = "INSERT INTO articulos_cajas (id_caja, cantidad, codigo, descripcion) 
			VALUES ('$id_caja', '$cantidad', '$codigo', '$descripcion')";

	$descripcion_completa = "caja". "|" . $codigo. "|". $cantidad;


	$update = "UPDATE cajas_articulos SET descripcion = '$descripcion_completa' WHERE id = '$id_caja'";
	$ex_update = mysqli_query($conexion, $update);
	$exSql = mysqli_query($conexion, $sql);
 ?>