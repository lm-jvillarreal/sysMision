<?php
	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$comentario = $_POST['comentario'];
	$mensaje    = "";

	$cadena_verificar = mysqli_query($conexion,"SELECT comentarios,id_persona FROM me_control_tiempos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_verificar);

	if ($comentario == $row[0]){
		$mensaje = "igual";
	}
	else{
		$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET comentarios = '$comentario' WHERE id = '$id'");
		$mensaje = "ok";
	}

	$array_datos = array($mensaje,$row[1]);
	$array = json_encode($array_datos);
	echo $array;	
?>