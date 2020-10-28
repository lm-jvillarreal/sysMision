<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_registro = $_POST['id_registro'];
	
	$cadena = mysqli_query($conexion,"SELECT img_presentacion,img_codigo
										FROM altas_productos
										WHERE id = '$id_registro'");
	$row = mysqli_fetch_array($cadena);

	$array  = array($row[0],$row[1]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>