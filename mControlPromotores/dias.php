<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("H:i:s");

	$id_promotor = $_POST['id_promotor'];

	$cadena   = mysqli_query($conexion,"SELECT DISTINCT(DAYOFWEEK(dia)) FROM agenda_promotores WHERE id_promotor = '$id_promotor'");
	$cantidad = mysqli_num_rows($cadena);
?>