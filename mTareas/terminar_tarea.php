<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	$consulta = mysqli_query($conexion,"SELECT activo FROM tareas WHERE id = '$id'");
	$row = mysqli_fetch_array($consulta);
	$qry = ($row[0] == "1")?"UPDATE tareas SET activo = '2', id_usuario = '$id_usuario' WHERE id = '$id'":"UPDATE tareas SET activo = '1', id_usuario = '$id_usuario' WHERE id = '$id'";
	$cadena = mysqli_query($conexion,$qry);
	echo "ok";
?>