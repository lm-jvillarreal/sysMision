<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT id_tipo, nombre, descripcion FROM tipos_equipos WHERE id_tipo = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>