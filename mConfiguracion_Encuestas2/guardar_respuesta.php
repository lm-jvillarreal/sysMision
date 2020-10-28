<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id_pregunta = $_POST['id_pregunta'];
	$respuesta   = $_POST['respuesta'];
	$respuesta = trim($respuesta);

	if($respuesta != ""){
		$cadena   = mysqli_query($conexion,"SELECT id FROM n_respuestas WHERE respuesta = '$respuesta' AND id_pregunta = '$id_pregunta' AND activo = '1'");
		$cantidad = mysqli_num_rows($cadena);

		if($cantidad == 0){
			$cadena2 = mysqli_query($conexion,"INSERT INTO n_respuestas (id_pregunta,respuesta,fecha,hora,activo,id_usuario)
				VALUES ('$id_pregunta','$respuesta','$fecha','$hora','1','$id_usuario')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		echo "vacio";
	}
?>