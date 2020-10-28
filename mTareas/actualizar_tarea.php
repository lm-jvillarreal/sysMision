<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre_tarea = $_POST['nombre_tarea'];
	$id           = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE tareas SET nombre = '$nombre_tarea' WHERE id = '$id'");
	echo "ok";
?>