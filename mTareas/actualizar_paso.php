<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre_paso = $_POST['nombre_paso'];
	$id          = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE tareas_pasos SET nombre = '$nombre_paso' WHERE id = '$id'");
	echo "ok";
?>