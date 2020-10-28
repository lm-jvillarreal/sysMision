<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                nombre
						              FROM
						                rublos
						              WHERE
						                activo = '1' 
						              AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array  = array($row[0]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>