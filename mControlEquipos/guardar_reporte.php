<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id_reporte    = $_POST['id_reporte'];
	
	$id_caja       = $_POST['id_caja_reporte'];
	
	$num_reporte   = $_POST['num_reporte'];
	$fecha_llegada = $_POST['fecha_llegada'];
	$falla         = $_POST['falla'];
	$num_serie     = $_POST['num_serie'];

	if (strlen(stristr($num_serie,'-'))>0) {
	}
	else{
	    ////////////////////Agrega giones///////////////////////
	    $num_serie = wordwrap($num_serie,3, "-",1);
	}

	if ($id_reporte == 0){

		$cadena_verificar = mysqli_query($conexion,"SELECT id FROM control_equipos WHERE numero_serie = '$num_serie'");
		$existe = mysqli_num_rows($cadena_verificar);

		if($existe != 0){
			$cadena = "INSERT INTO historial_equipos (id_caja,num_reporte,fecha_llegada,falla,num_serie_anterior,fecha,hora,id_usuario,activo,actualizo)
			VALUES('$id_caja','$num_reporte','$fecha_llegada','$falla','$num_serie','$fecha','$hora','$id_usuario','1','0')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}
		else{
			echo "1";
		}
		
	}
	else{
		$actualizar  = mysqli_query($conexion,"UPDATE historial_equipos SET num_reporte = '$num_reporte', fecha_llegada = '$fecha_llegada', falla = '$falla', num_serie_anterior = '$num_serie', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_reporte'");
		echo "ok";
	}
?>