<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                nombre
						              FROM
						                conceptos_cotizacion
						              WHERE
						                activo = '1' 
						              AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	echo $row[0];
?>