<?php
	include '../global_seguridad/verificar_sesion.php';

	$id      = $_POST['id'];
	$tipo    = $_POST['tipo'];
	$mensaje = "";

	$cadena_verificar = mysqli_query($conexion,"SELECT tipo,id_persona FROM me_control_tiempos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_verificar);

	if ($tipo == $row[0]){
		$mensaje = "igual";
	}
	else{
		$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET tipo = '$tipo' WHERE id = '$id'");
		$mensaje= "ok";
	}

	$array_datos = array($mensaje,$row[1]);
	$array       = json_encode($array_datos);
	echo $array;	
?>