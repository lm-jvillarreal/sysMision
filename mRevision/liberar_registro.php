<?php
	include '../global_seguridad/verificar_sesion.php';

	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	$estatus     = $_POST['estatus'];
	$comentario  = $_POST['comentario'];
	
	$cadena = mysqli_query($conexion,"UPDATE altas_productos SET fecha_libero = '$fecha', hora_libero = '$hora', estatus = '$estatus',comentario = '$comentario' WHERE id = '$id_registro'");
	echo "ok";
?>