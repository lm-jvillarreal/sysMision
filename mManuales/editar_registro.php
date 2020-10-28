<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	
	$cadena = mysqli_query($conexion,"SELECT nombre,descripcion,categoria,ruta
						              FROM
						                manuales
						              WHERE
						                activo = '1' 
						              AND id = '$id_registro'");

	$row = mysqli_fetch_array($cadena);

	$array  = array($row[0],$row[1],$row[2],$row[3]);
	$array1 = json_encode($array);
	echo $array1;	
?>