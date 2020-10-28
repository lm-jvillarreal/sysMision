<?php
	include '../global_seguridad/verificar_sesion.php';

	
	$id_actividad = $_POST['id_actividad'];
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_fin    = $_POST['fecha_fin'];
	
	$repetir      = $_POST['repetir'];
	
	$repite            = $_POST['repite'];
	$dias_selecionados = $_POST['dias_selecionados'];
	
	$duracion = $_POST['duracion'];
	$finaliza = $_POST['finaliza'];
	
	$fecha_final2   = $_POST['fecha_final2'];
	$mensaje        = 0;
	$cadena         = "";
	$frecuencia     = "";
	$fecha_finaliza = "";

	//Verificacion de si se repite o no
	if($repetir == 0){ //No Repite

		///Verficacion de Fechas
		if($fecha_inicio == $fecha_fin){
			$mensaje = "1"; //Fecha Igual
			echo $mensaje;
			return false;
		}	
		//Verificacion de Hora
		$verificacion_horas = strpos($fecha_inicio, ':');
		if($verificacion_horas === false){
			$mensaje = "2"; //Falta Hora
			echo $mensaje;
			return false;
		}
		if($fecha_inicio > $fecha_fin){
			$mensaje = "3"; //Fecha Inicio Mayor que Final
			echo $mensaje;
			return false;
		}else{
			$hora_inicio = substr($fecha_inicio, 10,8);
			$fecha_inicio = substr($fecha_inicio, 0,10);

			$hora_fin = substr($fecha_fin, 10,8);
			$fecha_fin = substr($fecha_fin, 0,10);

			$cadena = "UPDATE detalle_checklist SET fecha_inicio = '$fecha_inicio', hora_inicio = '$hora_inicio', fecha_fin = '$fecha_fin', hora_fin = '$hora_fin', se_repite = '$repetir', programada = '1' WHERE id = '$id_actividad'";
		}
	}else{ //Si Repite

		//Verificacion de Hora
		$verificacion_horas = strpos($fecha_inicio, ':');
		if($verificacion_horas === false){
			$mensaje = "2"; //Falta Hora
			echo $mensaje;
			return false;
		}

		//Verifica si se repite esta en por semana
		if($repite == 2){
			//Verificar si se seleccionaron dias
			if($dias_selecionados == ""){
				$mensaje = "4"; //No Selecciono dias
				echo $mensaje;
				return false;
			}
			//Separar dias
			$dias = explode(',', $dias_selecionados);
			foreach ($dias as $dia) {
				$frecuencia .= "$dia = '1', ";
			}
		}
		//verifica que si la actividad finaliza o no
		if($finaliza == 1){
			//Verifica si la fecha de finalizacion es mayor a la fecha de inicio
			if($fecha_final2 < $fecha_inicio){
				$mensaje = "5"; //Fecha Incorrecta
				echo $mensaje;
				return false;
			}
			$fecha_finaliza = "finaliza = '1', dia_finaliza = '$fecha_final2' ";
		}else{
			$fecha_finaliza = "finaliza = '0' ";
		}

		$hora_inicio  = substr($fecha_inicio, 10,8);
		$fecha_inicio = substr($fecha_inicio, 0,10);
		
		$cadena = "UPDATE detalle_checklist SET programada = '1',fecha_inicio = '$fecha_inicio', hora_inicio = '$hora_inicio', se_repite = '$repetir', frecuencia = '$repite',".$frecuencia."duracion = '$duracion',".$fecha_finaliza."WHERE id = '$id_actividad'";
	}

	$consulta = mysqli_query($conexion,$cadena);
	echo "ok";
?>