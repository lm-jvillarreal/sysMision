<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_actividad = $_POST['id_actividad'];

	$cadena = mysqli_query($conexion,"SELECT actividad FROM actividades_promotor WHERE id = '$id_actividad'");
	$row = mysqli_fetch_array($cadena);

	echo $row[0];
?>