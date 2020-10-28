<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
	
	$paso  = $_POST['paso'];
	$paso  = trim($paso);
	$tarea = $_POST['tarea'];

	if($paso != "" && $tarea != ""){
		$verificar = mysqli_query($conexion,"SELECT nombre FROM tareas_pasos WHERE nombre = '$paso' AND activo = '1' AND id_tarea = '$tarea'");
		$cantidad  = mysqli_num_rows($verificar);

		if ($cantidad == 0){
			$cadena = "INSERT INTO tareas_pasos (id_tarea,nombre,fecha,hora,activo,id_usuario)
					VALUES ('$tarea','$paso','$fecha','$hora','1','$id_usuario')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}else{
		echo "vacio";
	}
?>
