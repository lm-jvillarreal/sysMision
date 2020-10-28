<?php
	include '../global_seguridad/verificar_sesion.php';

	$promotor_m    = $_POST['promotor_m'];

	$cadena_veri = mysqli_query($conexion,"SELECT id FROM agenda_promotores WHERE id_promotor = '$promotor_m' AND dia = '$fecha' AND id_sucursal = '$id_sede'");
	$existe = mysqli_num_rows($cadena_veri);
	if($existe != 0){
		echo "duplicado";
	}else{
		$cadena_verificar = mysqli_query($conexion,"SELECT hora_inicio,hora_fin FROM agenda_promotores WHERE id_promotor = '$promotor_m'");
		$row_verificar = mysqli_fetch_array($cadena_verificar);
		$cadena = mysqli_query($conexion,"INSERT INTO agenda_promotores (id_promotor,id_sucursal,dia,hora_inicio,hora_fin,fecha,hora,id_usuario,activo,especial)
			VALUES ('$promotor_m','$id_sede','$fecha','$row_verificar[0]','$row_verificar[1]','$fecha','$hora','$id_usuario','1','1')");
		echo "ok";
	}
?>