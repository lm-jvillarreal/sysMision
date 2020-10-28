<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$encuesta  = (isset($_POST['encuesta']))?$_POST['encuesta']:"";
	$pregunta  = (isset($_POST['pregunta']))?$_POST['pregunta']:"";
	$respuesta = (isset($_POST['respuesta']))?$_POST['respuesta']:"";
	$cantidad = ($respuesta != "")?count($respuesta):"";
	$mensaje = "";

	$cadena_com = mysqli_query($conexion,"SELECT comentario FROM s_encuestas WHERE id= '$encuesta'");
	$row_com = mysqli_fetch_array($cadena_com);
	if($row_com[0] == "1"){
		$comentario = $_POST['comentario'];
		$comentario = trim($comentario);

		if(empty($comentario)){
			$mensaje = "vacio";
		}else{
			$cadena2 = mysqli_query($conexion,"INSERT INTO s_respuestas (id_pregunta,respuesta,activo,fecha,hora,id_usuario,especial) VALUES('0','$comentario','1','$fecha','$hora','$id_usuario','$encuesta')");
		}
	}

	$o = 0;
	while ($o < $cantidad) {
		$resp = $respuesta[$o];
		if(trim($resp) == ""){
			$mensaje = "vacio";
			break;
		}
		$o++;
	}

	if($mensaje == ""){
		for ($i=0; $i < $cantidad ; $i++) { 
			$cadena = mysqli_query($conexion,"INSERT INTO s_respuestas (id_pregunta,respuesta,activo,fecha,hora,id_usuario,especial) VALUES('$pregunta[$i]','$respuesta[$i]','1','$fecha','$hora','$id_usuario','0')");
		}

		$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE title LIKE '$encuesta - Encuesta%' AND id_usuario = '$id_usuario'");
	}else{
		echo $mensaje;
	}
	
?>