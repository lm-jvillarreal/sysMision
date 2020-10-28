<?php
	include '../global_seguridad/verificar_sesion.php';

	$id    = $_POST['id'];
	$actividad = $_POST['actividad'];

	$cadena = mysqli_query($conexion,"UPDATE actividades_usuario SET actividad = '$actividad' WHERE folio = '$id'");
	echo "ok";
?>