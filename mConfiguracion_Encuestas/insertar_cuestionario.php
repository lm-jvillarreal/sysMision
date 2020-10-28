<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$nombre_cuestionario = $_POST['nombre'];
	$fecha_inicio        = $_POST['fecha_inicio'];
	$fecha_fin           = $_POST['fecha_fin'];
	$cantidad            = $_POST['cantidad'];
	$preguntas           = $_POST['preguntas'];
	$cantidad_preguntas  = count($preguntas);
	$sucursal            = $_POST['sucursal'];
	$cantidad_sucursales  = count($sucursal);
	

	////////////////////////////////////////INSERTAR CUESTIONARIO////////////////////////////////////
	$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM cuestionarios");
	$row_folio = mysqli_fetch_array($cadena_folio);
	
	if($row_folio[0] == ""){
		$folio = 0;
	}
	else{
		$folio = $row_folio[0] + 1;
	}

	for ($n=0; $n < $cantidad_sucursales ; $n++) { 
		$cadena = mysqli_query($conexion,"INSERT INTO cuestionarios (nombre,cantidad_encuestados,fecha_inicio,fecha_fin,id_usuario,fecha,hora,activo,encuestados,folio,id_sucursal) 
			VALUES('$nombre_cuestionario','$cantidad','$fecha_inicio','$fecha_fin','$id_usuario','$fecha','$hora','1','0','$folio','$sucursal[$n]')");
	}

	////////////////////////////////////////TRAER ULTIMO ID CREADO////////////////////////////////////
	// $cadena_cuestionario = mysqli_query($conexion,"SELECT MAX(id) FROM cuestionarios");
	// $row_cuestionario = mysqli_fetch_array($cadena_cuestionario);

	////////////////////////////////////////INSERTAR PREGUNTAS AL CUESTIONARIO////////////////////////////////////
	for ($i=0; $i < $cantidad_preguntas ; $i++) { 
		$cadena = mysqli_query($conexion,"INSERT INTO encuestas (folio_cuestionario,id_pregunta,fecha,hora,id_usuario,activo)
					VALUES ('$folio','$preguntas[$i]','$fecha','$hora','$id_usuario','1')");
	}
	echo "ok";
?>