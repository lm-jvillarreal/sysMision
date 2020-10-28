<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	// include '../global_settings/conexion_pruebas.php';
	// include '../global_settings/conexion_oracle.php';
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$zona = $_POST["zona"];
	$mueble = $_POST["mueble"];
	$cara = $_POST["cara"];
	$sucursal = $_POST["sucursal"];
	$area = $_POST["area"];
	$qry = "UPDATE inv_mapeo SET zona = '$zona', mueble='$mueble', cara= '$cara', id_sucursal = '$sucursal', id_area = '$area' WHERE id = $id";
	
	echo "$sql";
	$exSql = mysqli_query($conexion, $qry);
 ?>