<?php

	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena2 = mysqli_query($conexion,"SELECT (SELECT nombre FROM checklist WHERE checklist.id = detalle_checklist.id_checklist),
											nombre,
											(SELECT nombre FROM sub_departamentos WHERE sub_departamentos.id = detalle_checklist.id_subdepartamento),
											fecha_inicio,
											fecha_fin,
											se_repite,
											frecuencia,
											d,l,m,x,j,v,s,
											duracion,
											finaliza,
											dia_finaliza,
											hora_inicio,
											hora_fin
										   FROM detalle_checklist 
										   WHERE id = '$id'");
	$row2 = mysqli_fetch_array($cadena2);
	$fecha_inicio = substr($row2[3], 0,19);
	$fecha_final  = substr($row2[4], 0,19);
	$frecuencia   = "";
	$duracion     = "";

	if($row2[6] == 1){
		$frecuencia = "Todos los dias";
	}else if($row2[6] == 2){
		$frecuencia = "Cada Semana";
	}else if($row2[6] == 3){
		$frecuencia = "Cada Quincena";
	}else if($row2[6] == 4){
		$frecuencia = "Cada Mes";
	}else if($row2[6] == 5){
		$frecuencia = "Cada Año";
	}

	if($row2[14] == 1){
		$duracion = '15 Minutos';
	}else if($row2[14] == 2){	
		$duracion = '30 Minutos';
	}else if($row2[14] == 3){	
		$duracion = '45 Minutos';
	}else if($row2[14] == 4){	
		$duracion = '1 Hora';
	}else if($row2[14] == 5){	
		$duracion = 'Todo el Dia';
	}
	$hora_inicio = substr($row2[17], 0,8);
	$hora_fin = substr($row2[18], 0,8);
	$array = array($row2[0], //nombre_checklist
					$row2[1], //nombre_actividad
					$row2[2], //sub_departamento
					$fecha_inicio.'-'.$hora_inicio, //fecha_inicio
					$fecha_final.'-'.$hora_fin, //fecha_fin
					$row2[5], //se_repite
					$frecuencia, //frecuencia
					$row2[7], //d
					$row2[8], //l
					$row2[9], //m
					$row2[10], //x
					$row2[11], //j
					$row2[12], //v
					$row2[13], //s
					$duracion, //duracion
					$row2[15], //finaliza
					$row2[16] //dia_finaliza
	);
	echo json_encode($array);
?>
