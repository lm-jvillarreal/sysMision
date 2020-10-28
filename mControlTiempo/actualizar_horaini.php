<?php
	include '../global_seguridad/verificar_sesion.php';

	$id          = $_POST['id'];
	$horaini     = $_POST['horaini'];
	$hora_inicio = $horaini.':00';
	$mensaje     = "";

	$cadena_verificar = mysqli_query($conexion,"SELECT hora_inicio,hora_fin,id_persona FROM me_control_tiempos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_verificar);

	if ($horaini == $row[0]){
		$mensaje = "igual";
	}
	else{
		// if ($horaini >= $row[1]){
		// 	$mensaje = "verifica";
		// }
		// else{
			$hora_final = $row[1];

			$inicio     = new DateTime($hora_inicio);
			$final      = new DateTime($hora_final);
			$interval   = $inicio->diff($final);
			$diferencia = $interval->format('%H:%i');
			
			$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET hora_inicio = '$horaini',diferencia = '$diferencia' WHERE id = '$id'");
			$mensaje = "ok";
		//}
	}

	$array_datos = array($mensaje,$row[2]);
	$array = json_encode($array_datos);
	echo $array;	
?>