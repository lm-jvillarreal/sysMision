<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"UPDATE n_encuestas SET activo = '0' WHERE folio = '$id'");
	$cadena = mysqli_query($conexion,"UPDATE n_preguntas SET activo = '0' WHERE folio = '$id'");
	echo "ok";
?>