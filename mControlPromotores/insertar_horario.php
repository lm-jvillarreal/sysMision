<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	$fechaInicio      = strtotime($fecha);
	$fecha_mas_un_mes = date("Y-m-d",strtotime($fecha."+ 1 year")); //a un año
	$fechaFin         = strtotime($fecha_mas_un_mes);

	$dia         = $_POST['dia'];
	$id_sucursal = $_POST['id_sucursal'];
	$hora_inicio = $_POST['hora_inicio'];
	$hora_final  = $_POST['hora_final'];
	$id_promotor = $_POST['id_promotor_h'];
	$id_horario  = $_POST['id_horario'];

	if($id_horario == 0){
		$dia_select = "";
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
			//Sacar el dia de la semana con el modificador N de la funcion date
			$dias = date('N', $i);
			if($dia == $dias){
			    $dia_select = date("Y-m-d", $i);
			    $cadena_verificar = mysqli_query($conexion,"SELECT id FROM agenda_promotores WHERE id_promotor = '$id_promotor' AND dia = '$dia_select' AND id_sucursal = '$id_sucursal' AND activo = '1'");
			    $existe = mysqli_num_rows($cadena_verificar);
			    if($existe == 0){
			    	$cadena = mysqli_query($conexion,
			    	"INSERT INTO agenda_promotores (id_promotor,dia,id_sucursal,hora_inicio,hora_fin,fecha,hora,id_usuario,activo)
			    	VALUES ('$id_promotor','$dia_select','$id_sucursal','$hora_inicio','$hora_final','$fecha','$hora','$id_usuario','1')");
			    }else{
			    	// echo "duplicado";
			    	//break;
			    }
			}
			$cadena     = "";
			$dia_select = "";
		}
		echo "ok";
	}else{
		$dia_bd  = $_POST['dia_bd'];
		$cadena = mysqli_query($conexion,"UPDATE agenda_promotores SET dia = '$dia_bd', id_sucursal = '$id_sucursal', hora_inicio = '$hora_inicio', hora_fin='$hora_final' WHERE id = '$id_horario'");
		echo "ok";
	}
?>
