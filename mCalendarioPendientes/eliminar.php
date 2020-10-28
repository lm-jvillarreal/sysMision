<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE pendientes_mantenimiento SET activo = '0' WHERE id = '$id'");

	$cadena2 = mysqli_query($conexion,"SELECT id_calendario FROM pendientes_mantenimiento WHERE id = '$id'");
	$row2 = mysqli_fetch_array($cadena2);

	$cadena = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$row2[0]'");
		
	echo "ok";
?>