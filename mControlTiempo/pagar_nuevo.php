<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$horas_disponibles = $_POST['horas_disponibles'];
	$horas_disp        = $_POST['horas_disp'];
	$h_pagar           = $_POST['h_pagar'];
	$comentario        = $_POST['comentario'];
	$id_pers           = $_POST['id_pers'];
	$hora_x = "00:00:00";

	if ($h_pagar != ""){
		$cadena = mysqli_query($conexion,"INSERT INTO me_control_tiempos (fecha,hora_inicio,hora_fin,diferencia,comentarios,id_usuario,tipo,fecha_registro,hora_registro,id_persona,activo,comentario_pagado)
	VALUES ('$fecha','$hora_x','$hora_x','$h_pagar','$comentario','$id_usuario','3','$fecha','$hora','$id_pers','1','$comentario')");
		echo "ok";
	}
	else{
		echo "1";
	}
?>