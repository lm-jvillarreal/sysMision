<?php
	include '../global_seguridad/verificar_sesion.php';

	$id    = $_POST['id'];
	$fecha = $_POST['fecha'];
	$mensaje = "";

	$cadena_verificar = mysqli_query($conexion,"SELECT fecha,id_persona FROM me_control_tiempos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_verificar);

	if ($fecha == $row[0]){
		$mensaje = "igual";
	}
	else{
		$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET fecha = '$fecha' WHERE id = '$id'");
		$mensaje = "ok";
	}

	$array_datos = array($mensaje,$row[1]);
	$array = json_encode($array_datos);
	echo $array;	
?>