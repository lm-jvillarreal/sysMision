<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	$fechaInicio      = strtotime($fecha);
	$fecha_mas_un_mes = date("Y-m-d",strtotime($fecha."+ 1 month")); 
	$fechaFin         = strtotime($fecha_mas_un_mes);

	$actividad    = $_POST['actividad'];
	$id_promotor  = $_POST['id_promotor_a'];
	$id_actividad = $_POST['id_actividad'];

	if($id_actividad == 0){
		$cadena = mysqli_query($conexion,"SELECT id FROM actividades_promotor WHERE id_promotor = '$id_promotor' AND actividad = '$actividad' AND temporal = '0'");
		$existe = mysqli_num_rows($cadena);
		if($existe == 0){
			$cadenaI = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad, id_promotor, fecha, hora, activo , id_usuario, principal,temporal)
					VALUES ('$actividad','$id_promotor','$fecha','$hora','1','$id_usuario','0','0')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$cadenaA = mysqli_query($conexion,"UPDATE actividades_promotor SET actividad = '$actividad', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_actividad'");
		echo "ok";		
	}
?>
