<?php
	include '../global_seguridad/verificar_sesion.php';

	
	$actividad_predeterminada = $_POST['actividad_predeterminada'];
	$id_check_list_modal      = $_POST['id_check_list_modal'];
	$tipo                     = $_POST['tipo'];
	$actividades              = (isset($_POST['actividades']))?$_POST['actividades']:"";
	$cantidad_act             = count($actividades);
	$cadena_act               = "";
	$filtro                   = "";
	if($actividad_predeterminada == ""){
		echo "vacio";
		return false;
	}

	$cadena = mysqli_query($conexion,"SELECT fecha_inicio,
				fecha_fin,
				hora_inicio,
				hora_fin,
				se_repite,
				frecuencia,
				d,l,m,x,j,v,s,
				duracion,
				finaliza,
				dia_finaliza FROM detalle_checklist WHERE id = '$actividad_predeterminada'");
	$row = mysqli_fetch_array($cadena);
	$fecha_inicio = ($row[0] == "")?"NULL":"'".$row[0]."'";
	$fecha_fin    = ($row[1] == "")?"NULL":"'".$row[1]."'";
	$hora_inicio  = ($row[2] == "")?"NULL":"'".$row[2]."'";
	$hora_fin     = ($row[3] == "")?"NULL":"'".$row[3]."'";
	$se_repite    = ($row[4] == "")?"NULL":"'".$row[4]."'";
	$frecuencia   = ($row[5] == "")?"NULL":"'".$row[5]."'";
	$d            = ($row[6] == "")?"NULL":"'".$row[6]."'";
	$l            = ($row[7] == "")?"NULL":"'".$row[7]."'";
	$m            = ($row[8] == "")?"NULL":"'".$row[8]."'";
	$x            = ($row[9] == "")?"NULL":"'".$row[9]."'";
	$j            = ($row[10] == "")?"NULL":"'".$row[10]."'";
	$v            = ($row[11] == "")?"NULL":"'".$row[11]."'";
	$s            = ($row[12] == "")?"NULL":"'".$row[12]."'";
	$duracion     = ($row[13] == "")?"NULL":"'".$row[13]."'";
	$finaliza     = ($row[14] == "")?"NULL":"'".$row[14]."'";
	$dia_finaliza = ($row[15] == "")?"NULL":"'".$row[15]."'";

	if($tipo == 1){ //Todos
		$cadena1 = mysqli_query($conexion,"SELECT id FROM detalle_checklist WHERE id_checklist = '$id_check_list_modal' AND programada = '0'");
		while ($row1 = mysqli_fetch_array($cadena1)) {

			$cadena_act = mysqli_query($conexion,"UPDATE detalle_checklist 
						SET
							programada   = '1',
							fecha_inicio = $fecha_inicio,
							fecha_fin    = $fecha_fin,
							hora_inicio  = $hora_inicio,
							hora_fin     = $hora_fin,
							se_repite    = $se_repite,
							frecuencia   = $frecuencia,
							d            = $d,
							l            = $l,
							m            = $m,
							x            = $x,
							j            = $j,
							v            = $v,
							s            = $s,
							duracion     = $duracion,
							finaliza     = $finaliza,
							dia_finaliza = $dia_finaliza
						WHERE id = '$row1[0]'");
		}		

	}else if($tipo == 2){ //Solo estos
		if($actividades == ""){
			echo "vacio";
			return false;
		}
		for ($i=0; $i < $cantidad_act; $i++) { 
			$cadena_act = mysqli_query($conexion,"UPDATE detalle_checklist 
						SET
							programada   = '1',
							fecha_inicio = $fecha_inicio,
							fecha_fin    = $fecha_fin,
							hora_inicio  = $hora_inicio,
							hora_fin     = $hora_fin,
							se_repite    = $se_repite,
							frecuencia   = $frecuencia,
							d            = $d,
							l            = $l,
							m            = $m,
							x            = $x,
							j            = $j,
							v            = $v,
							s            = $s,
							duracion     = $duracion,
							finaliza     = $finaliza,
							dia_finaliza = $dia_finaliza
						WHERE id = '$actividades[$i]'");
		}

	}else if($tipo == 3){ //Excepto estos
		if($actividades == ""){
			echo "vacio";
			return false;
		}
		for ($i=0; $i < $cantidad_act ; $i++) { 
			$filtro .= "AND id != $actividades[$i] ";
		}
		$cadena_act = mysqli_query($conexion,"UPDATE detalle_checklist 
						SET
							programada   = '1',
							fecha_inicio = $fecha_inicio,
							fecha_fin    = $fecha_fin,
							hora_inicio  = $hora_inicio,
							hora_fin     = $hora_fin,
							se_repite    = $se_repite,
							frecuencia   = $frecuencia,
							d            = $d,
							l            = $l,
							m            = $m,
							x            = $x,
							j            = $j,
							v            = $v,
							s            = $s,
							duracion     = $duracion,
							finaliza     = $finaliza,
							dia_finaliza = $dia_finaliza
						WHERE programada = '0' AND id_checklist = '$id_check_list_modal' ".$filtro);
	}
	echo "ok";
?>