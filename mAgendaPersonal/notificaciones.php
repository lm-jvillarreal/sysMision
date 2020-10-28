<?php
	include '../global_seguridad/verificar_sesion.php';

	date_default_timezone_set('America/Monterrey');

	$fecha=date("Y-m-d"); 

	$fecha1 = "";
	$fecha2 = "";
	$notificaciones = "";
	$cantidad = 0;

	$filtro=(!empty($registros_propios) == '1')?"AND id_usuario = '$id_usuario'":"";

	$qry = "SELECT title FROM agenda WHERE '".$fecha." 12:00:01' BETWEEN start AND end ".$filtro;
	// echo $qry;
	$cadena   = mysqli_query($conexion,$qry);
	$cant     = mysqli_num_rows($cadena);
	
	if ($cant==0) {
		$notificaciones = "No tienes pendientes para hoy.";
	}elseif ($cant>0) {
		$notificaciones = "Tienes $cant actividad(es) agendadas para hoy.";
	}
	$renglon = "";
	$cuerpo = "";
	while ($row_notificaciones=mysqli_fetch_array($cadena)) {
		$id_encuesta = intval(preg_replace('/[^0-9]+/', '', $row_notificaciones[0]), 10);
		if($row_notificaciones[0] == $id_encuesta.' - Encuesta'){
			$renglon = "<li><a href='#' data-id = '$id_encuesta' data-toggle = 'modal' data-target = '#modal-default5' target='blank'><i class='fa fa-warning text-green'></i> $row_notificaciones[0]</a></li>";
		}else{
			$renglon = "<li><a href='#'><i class='fa fa-warning text-green'></i> $row_notificaciones[0]</a></li>";	
		}
		$cuerpo = $cuerpo.$renglon;
	}

	$array = array($cant,$notificaciones,$cuerpo);
	$array1 = json_encode($array);
	echo $array1;
?> 