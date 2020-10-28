<?php
	include '../global_seguridad/verificar_sesion.php';

	$checklist = $_POST['checklist'];

	$cadena = mysqli_query($conexion,"SELECT nombre FROM checklist WHERE id = '$checklist'");
	$row = mysqli_fetch_array($cadena);
	echo $row[0];
?>