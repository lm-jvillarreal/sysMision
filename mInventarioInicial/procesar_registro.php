<?php
	include '../global_seguridad/verificar_sesion.php';

	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	
	$cadena = mysqli_query($conexion,"UPDATE altas_productos SET fecha_proceso = '$fecha', hora_proceso = '$hora',usuario_proceso = '$id_usuario', estatus = '1' WHERE id = '$id_registro'");
?>