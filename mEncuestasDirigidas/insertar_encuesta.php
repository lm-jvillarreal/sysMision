<?php
	// include 'simplexlsx.class.php';
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$nombre_encuesta = $_POST['n_encuesta'];
	if(isset($_POST['comentario'])){
		$comentario = "1";
	}else{
		$comentario = "0";
	}
	$nombre_encuesta = trim($nombre_encuesta);
	$id_registro     = $_POST['id_registro'];

	$mensaje = "";
	$folio   = 0;

	if($id_registro == 0){
		if($nombre_encuesta != ""){
			$cadena_verificar = mysqli_query($conexion,"SELECT id FROM s_encuestas WHERE nombre = '$nombre_encuesta'");
			$existe = mysqli_num_rows($cadena_verificar);
			if($existe == 0){
				$consulta_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM s_encuestas");
				$row = mysqli_fetch_array($consulta_folio);
				$folio = ($row[0] == "")?"1":$row[0] + 1;
				$cadena = mysqli_query($conexion,"INSERT INTO s_encuestas (folio,nombre,fecha,hora,activo,id_usuario,comentario)
					VALUES ('$folio','$nombre_encuesta','$fecha','$hora','1','$id_usuario','$comentario')");
				$mensaje = "ok";
			}else{
				$mensaje = "duplicado";
			}
		}else{
			$mensaje = "vacio";
		}
		
	}else{
		$cadena = mysqli_query($conexion,"UPDATE s_encuestas SET nombre = '$nombre_encuesta', comentario = '$comentario' WHERE id = '$id_registro'");
		$mensaje = "ok";
		$folio = $id_registro;
	}

	$array = array($mensaje, $folio);
	echo json_encode($array);
?>