<?php
	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$horafin    = $_POST['horafin'];
	$hora_final = $horafin.':00';
	$mensaje    = "";

	$cadena_verificar = mysqli_query($conexion,"SELECT hora_fin,hora_inicio,id_persona FROM me_control_tiempos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_verificar);

	if ($hora_final == $row[0]){
		$mensaje = "igual";
	}
	else{
		// if ($horafin >= $row[1]){
		// 	$mensaje = "verifica";
		// }
		// else{
			$hora_inicio = $row[1];

			$inicio     = new DateTime($hora_inicio);
			$final      = new DateTime($hora_final);
			$interval   = $inicio->diff($final);
			$diferencia = $interval->format('%H:%i');
			$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET hora_fin = '$horafin',diferencia = '$diferencia' WHERE id = '$id'");
			$mensaje = "ok";
		//}
	}

	$array_datos = array($mensaje,$row[2]);
	$array = json_encode($array_datos);
	echo $array;	
?>