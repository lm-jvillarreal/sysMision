<?php
	include '../global_settings/conexion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT id, nombre, comentario FROM s_encuestas WHERE id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[1],$row[2]);

	echo json_encode($array);
?>