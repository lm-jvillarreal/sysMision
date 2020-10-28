<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$id                  = $_POST['id'];
	$id_sucursal         = $_POST['id_sucursal'];
	$respuesta           = $_POST['respuesta'];
	$pregunta            = $_POST['pregunta'];
	$comentario_pregunta = $_POST['comentario_pregunta'];
	$mensaje             = "";
	$cantidad_respuesta  = count($pregunta);
	$audio               = $_POST['audio'];
	$id_audio            =0;

	if($audio == "1"){
		$cadena_audio = mysqli_query($conexion,"SELECT MAX(id) FROM audios");
		$row_audio = mysqli_fetch_array($cadena_audio);
		$id_audio = $row_audio[0];
	}


	////////////////////// VERIFICAR QUE LOS CAMPOS NO ESTEN VACIOS//////////////////////
	for ($i=0; $i < $cantidad_respuesta ; $i++) { 
		if($respuesta[$i] == ""){
			$mensaje = "vacio";
			break;
		}
	}
	//////////////////////INSERTAR RESPUESTA/////////////////
	if($mensaje == ""){
		///////////////////////VERIFICAR DATOS DE ENCUESTADO///////////////////////
		$nombre        = $_POST['nombre_persona'];
		$direccion     = $_POST['direccion'];
		$telefono      = $_POST['telefono'];
		$sexo          = $_POST['sexo'];
		$comentarios   = $_POST['comentarios'];
		$encargado     = $_POST['encargado'];
		$id_encuestado = 0;

		if(!empty($encargado)){
			$cadena = mysqli_query($conexion,"INSERT INTO encuestados (nombre,direccion,telefono,comentarios,sexo,fecha,hora,id_usuario,id_audio,encargado) VALUES ('$nombre','$direccion','$telefono','$comentarios','$sexo','$fecha','$hora','$id_usuario','$id_audio','$encargado')");
			///////////////TRAER ULTIMO ID GUARDADO//////////////////////
			$cadena_id     = mysqli_query($conexion,"SELECT MAX(id) FROM encuestados");
			$row_cadena_id = mysqli_fetch_array($cadena_id);
			$id_encuestado = $row_cadena_id[0];
		}

		for ($o=0; $o < $cantidad_respuesta ; $o++) {
			$cadena_respuestas = mysqli_query($conexion,"INSERT INTO resultados_encuestas(id_cuestionario,id_pregunta,id_encuestado,respuesta,comentario,fecha,hora,id_usuario,activo,id_sucursal)
								VALUES ('$id','$pregunta[$o]','$id_encuestado','$respuesta[$o]','$comentario_pregunta[$o]','$fecha','$hora','$id_usuario','1','$id_sucursal')");
		}
		
		$cadena_cant = mysqli_query($conexion,"SELECT encuestados FROM cuestionarios WHERE folio = '$id'");
		$row_cadena_cant = mysqli_fetch_array($cadena_cant);

		$encuestados = 0;
		if($row_cadena_cant[0] == ""){
			$encuestados = 1;
		}else{
			$encuestados = $row_cadena_cant[0] + 1;
		}
		$cadena_actualizar = mysqli_query($conexion,"UPDATE cuestionarios SET encuestados = '$encuestados' WHERE folio = '$id'");
		echo "ok";
	}
	else{
		echo $mensaje;
	}
	//////////////////////////////////////INSERTAR CUESTIONARIO////////////////////////////////////
	
?>