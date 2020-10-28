<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	$id_promotor = $_POST['id_promotor'];

	$cadena_verificar = mysqli_query($conexion,"SELECT id, hora_salida FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' AND hora_salida is null");
	$existen = mysqli_num_rows($cadena_verificar);

	if ($existen == 0){
		echo "existe";
	}else{
		$cadena1 = mysqli_query($conexion,"SELECT SEC_TO_TIME((TIME_TO_SEC(hora_fin) - TIME_TO_SEC(hora_inicio))) FROM agenda_promotores WHERE id_promotor = '$id_promotor' AND dia = '$fecha' AND id_sucursal = '$id_sede' AND activo = '1'");

		$row_tiempo = mysqli_fetch_array($cadena1); //limite

		$cadena2 = mysqli_query($conexion,"SELECT hora_entrada FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
		$row_tiempo2 = mysqli_fetch_array($cadena2);

		$hora_ini = $row_tiempo2[0];
	    $hora_fin = $hora;
	    $fecha = date("Y-m-d");

	    $ts_fin = new DateTime($fecha." ".$hora);
	    $ts_ini = new DateTime($fecha." ".$row_tiempo2[0]);

		$interval   = date_diff($ts_fin, $ts_ini);
		$diferencia = $interval->format("%H:%I:%S"); //salida

		if($diferencia >= $row_tiempo[0]){
			$cadena2 = mysqli_query($conexion,"SELECT registro_actividades.id_actividad FROM registro_actividades
                INNER JOIN actividades_promotor ON actividades_promotor.id = registro_actividades.id_actividad
                INNER JOIN promotores ON promotores.id = actividades_promotor.id_promotor
                WHERE promotores.id = '$id_promotor' AND registro_actividades.fecha = '$fecha' AND registro_actividades.duracion is null AND registro_actividades.hora_fin is null AND registro_actividades.id_sucursal = '$id_sede'");
		    $existe2 = mysqli_num_rows($cadena2);
		    if($existe2 != 0){
		    	echo "pendiente";
		    }else{
		    	$actulizar = mysqli_query($conexion,"UPDATE registro_entrada SET hora_salida = '$hora' WHERE id_promotor ='$id_promotor' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
				$desactivar = mysqli_query($conexion,"UPDATE agenda_promotores SET activo = '2' WHERE id_promotor = '$id_promotor' AND dia = '$fecha' AND id_sucursal = '$id_sede'");
				echo "ok";
		    }
		}else{
			echo "no";
		}
	}
?>