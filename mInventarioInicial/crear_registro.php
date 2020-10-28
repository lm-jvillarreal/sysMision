<?php 
	include '../global_settings/conexion_supsys.php';
	$sucursal = $_POST['sucursal'];
	$fecha = $_POST['fecha'];
	$sql = "INSERT INTO existencias (id_sucursal, fecha) VALUES('$sucursal', '$fecha')";
	$exSql = mysqli_query($conexion, $sql);
	$Sm = "SELECT MAX(id) FROM existencias";
	$exSm = mysqli_query($conexion, $Sm);
	$row = mysqli_fetch_row($exSm);
	echo "$row[0]";
?>