<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha =date("Y-m-d"); 
	$hora  =date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET activo = '0' WHERE id = '$id'");
	
?>