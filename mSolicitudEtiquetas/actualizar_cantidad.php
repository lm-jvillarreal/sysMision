<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	$cantidad = $_POST['cantidad'];

	$cadena = mysqli_query($conexion,"UPDATE detalle_solicitud SET cantidad = '$cantidad' WHERE id = '$id'");

?>