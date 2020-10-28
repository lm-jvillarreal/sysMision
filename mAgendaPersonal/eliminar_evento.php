<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT folio FROM agenda WHERE id = '$id'");
	$row_cadena = mysqli_fetch_array($cadena);

	$cadena = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row_cadena[0]'");
	echo "ok";
?>