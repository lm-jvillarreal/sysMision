<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id_marca = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT marca,id_equipo FROM marcas WHERE id = '$id_marca'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>