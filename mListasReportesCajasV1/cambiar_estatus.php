<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$comentario = $_POST['comentario'];
	$cadena = mysqli_query($conexion,"UPDATE reportes_cajas SET status = '3', comentario = '$comentario', fecha_reparacion = '$fecha', hora_reparacion = '$hora', id_usuario_reparacion = '$id_usuario' WHERE id = '$id'");
	$cadena_calendario = mysqli_query($conexion,"DELETE FROM agenda WHERE title LIKE '$id-Reporte Falla.%'");
	echo "ok";
?>