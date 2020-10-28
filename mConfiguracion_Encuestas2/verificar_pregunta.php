<?php
	include '../global_settings/conexion.php';
	$pregunta = $_POST['pregunta'];

	$cadena = mysqli_query($conexion,"SELECT tipo FROM n_preguntas WHERE id = '$pregunta'");
	$row    = mysqli_fetch_array($cadena);

	echo $row[0];

?>