<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$encuesta  = (isset($_POST['encuesta']))?$_POST['encuesta']:"";
	$pregunta  = (isset($_POST['pregunta']))?$_POST['pregunta']:"";
	$respuesta = (isset($_POST['respuesta']))?$_POST['respuesta']:"";
	$cantidad = ($respuesta != "")?count($respuesta):"";

	$o = 0;
	$mensaje = "";
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
			$cadena = mysqli_query($conexion,"INSERT INTO s_respuestas (id_pregunta,respuesta,activo,fecha,hora,id_usuario) VALUES('$pregunta[$i]','$respuesta[$i]','1','$fecha','$hora','$id_usuario')");
		}

		$eliminar_evento = mysqli_query($conexion,"DELETE FROM agenda WHERE title LIKE '$encuesta - Encuesta%' AND id_usuario = '$id_usuario'");
	}else{
		echo $mensaje;
	}
	
?>