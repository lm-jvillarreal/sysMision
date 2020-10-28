<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_rancho = $_POST['id_rancho'];

	$cadena = mysqli_query($conexion,"SELECT encargado FROM ranchos WHERE id = '$id_rancho'");
	$row = mysqli_fetch_array($cadena);
	echo $row[0];
?>
