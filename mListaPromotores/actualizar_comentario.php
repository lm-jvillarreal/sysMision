<?php
	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$comentario = $_POST['comentario'];

	$cadena = mysqli_query($conexion,"UPDATE registro_actividades SET comentario = '$comentario' WHERE id = '$id'");
	echo "ok";
?>