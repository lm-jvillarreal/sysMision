<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"UPDATE s_preguntas SET activo = '0' WHERE id = '$id'");
	echo "ok";
?>