<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_rancho = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT nombre_rancho, tipo, estado, municipio, encargado FROM ranchos WHERE id = '$id_rancho'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2],$row[3],$row[4]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>