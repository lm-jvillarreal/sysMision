<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT nombre FROM fallas_equipos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0]);
	$array1 = json_encode($array);
	echo $array1;	
?>