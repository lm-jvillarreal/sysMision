<?php
	include '../global_seguridad/verificar_sesion.php';

	$id     = $_POST['id'];
	$hora   = $_POST['hora'];
	$tipo   = $_POST['tipo'];
	$filtro = ($tipo == 1)?"hora_inicio":"hora_fin";

	$hora = ($hora == "" || $hora == "00:00:00")?'NULL':"'".$hora."'";
	
	$cadena = mysqli_query($conexion,"UPDATE registro_actividades SET ".$filtro." = $hora WHERE id = '$id'");

	$cadena2 = mysqli_query($conexion,"SELECT hora_inicio , hora_fin, (SEC_TO_TIME(TIME_TO_SEC(hora_fin) - TIME_TO_SEC(hora_inicio))) FROM registro_actividades WHERE id = '$id'");
	$row2 = mysqli_fetch_array($cadena2);
	if($row2[0] != "" && $row2[1] != ""){
		$difetencia = $row2[2];
		$cadena3 = mysqli_query($conexion,"UPDATE registro_actividades SET duracion = '$difetencia' WHERE id = '$id'");
	}else{
		$difetencia = 'NULL';
		$cadena3 = mysqli_query($conexion,"UPDATE registro_actividades SET duracion = $difetencia WHERE id = '$id'");
	}	
	echo "ok";
?>