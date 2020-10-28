<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena =  mysqli_query($conexion,"UPDATE preguntas SET activo = '0' WHERE folio  = '$id'");
	echo "ok";
?>