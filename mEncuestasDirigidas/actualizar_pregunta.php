<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	$pregunta = $_POST['pregunta'];

	$cadena = mysqli_query($conexion,"UPDATE s_preguntas SET pregunta = '$pregunta' WHERE id = '$id'");
	echo "ok";
?>