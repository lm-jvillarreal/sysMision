<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
						                num_reporte,fecha_llegada,falla,num_serie_anterior
						              FROM historial_equipos
						              WHERE activo = '1' 
						              AND id = '$id'");

	$row = mysqli_fetch_array($cadena);

	$array  = array($row[0],$row[1],$row[2],$row[3],$id);
	$array1 = json_encode($array);
	echo $array1;	
?>