<?php
	include '../global_seguridad/verificar_sesion.php';

	$promotor     = $_POST['promotor'];
	$fecha        = $_POST['fecha'];
	$hora_entrada = $_POST['hora_entrada'];
	$hora_salida  = $_POST['hora_salida'];
	$id_entrada   = $_POST['id_entrada'];
	$cajas_e      = $_POST['cajas_e'];
	$cajas        = $_POST['cajas'];

	if(!empty($hora_salida)){
		$filtro = " , hora_salida = '$hora_salida'";
	}else{
		$filtro = "";
	}

	if($cajas_e == 1){
		$cadena = mysqli_query($conexion,"SELECT id,actividad FROM actividades_promotor WHERE id_promotor = '$promotor' AND principal = '1'");
	    $row = mysqli_fetch_array($cadena);

	    $cadena1 = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad,id_promotor,fecha,hora,id_usuario,activo,principal,temporal)
	        VALUES ('Surtir Cajas Extra','$promotor','$fecha','$hora','$id_usuario','1','0','1')");

	    $cadena2 = mysqli_query($conexion,"SELECT MAX(id) FROM actividades_promotor");
	    $row2 = mysqli_fetch_array($cadena2);

	    $cadena3 = mysqli_query($conexion,"INSERT INTO registro_actividades (duracion,id_actividad,hora_inicio,hora_fin,fecha,hora,activo,id_usuario,cajas_surtidas,id_sucursal) VALUES('00:00:00','$row2[0]','$hora','$hora','$fecha','$hora','1','$id_usuario','$cajas','$id_sede')");
	}else{
		$filtro2 = "";
	}

	$cadena4 = mysqli_query($conexion,"UPDATE registro_entrada SET hora_entrada = '$hora_entrada'".$filtro." WHERE id = '$id_entrada'");
	echo "ok";
?>