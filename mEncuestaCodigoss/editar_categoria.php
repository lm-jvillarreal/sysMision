<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT nombre FROM categoria_codigos WHERE activo = '1' AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array  = array($id, $row[0]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>