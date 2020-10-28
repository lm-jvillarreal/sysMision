<?php

	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre,programada FROM detalle_checklist WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0],$row[1]);
	echo json_encode($array);
?>