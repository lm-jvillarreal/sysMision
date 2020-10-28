<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_actividad = 0;
	$actividad    = $_POST['actividad'];
	$cronometro   = $_POST['cronometro'];
	$usuario      = $_POST['usuario'];


	$cadena    = mysqli_query($conexion,"SELECT MAX(folio) FROM actividades_usuario");
	$row_folio = mysqli_fetch_array($cadena);
	$folio     = $row_folio[0] + 1;


	if($cronometro == 0){
		if(!empty($_POST['usuario'])){
			$cadena_insertar = "INSERT INTO actividades_usuario (folio,actividad,cronometro,fecha, hora, activo, id_usuario,tipo, principal,estatus)VALUES('$folio','$actividad', '$cronometro', '$fecha', '$hora', '1', '$usuario','2','0','0')";
			$insertar = mysqli_query($conexion, $cadena_insertar);
		}
		$cadena_insertar = "INSERT INTO actividades_usuario (folio,actividad,cronometro,fecha, hora, activo, id_usuario,tipo,principal,estatus)VALUES('$folio','$actividad', '$cronometro', '$fecha', '$hora', '1', '$id_usuario','2','1','1')";
	}else{
		$cadena_insertar = "INSERT INTO actividades_usuario (folio,actividad,cronometro,fecha, hora, activo, id_usuario,tipo,hora_inicio,principal,estatus)VALUES('$folio','$actividad', '$cronometro', '$fecha', '$hora', '1', '$id_usuario','2','$hora','1','1')";
	}
	$insertar = mysqli_query($conexion, $cadena_insertar);

	echo "ok";
?>