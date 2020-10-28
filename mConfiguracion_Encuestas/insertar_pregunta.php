<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$cantidad      = "";
	$pregunta      = $_POST['pregunta'];
	$tipo_pregunta = $_POST['tipo_pregunta'];
	$departamento  = $_POST['departamento'];
	$categoria     = $_POST['categoria'];
	$cantidad      = count($departamento);


	$verificar = mysqli_query($conexion,"SELECT id FROM preguntas WHERE pregunta = '$pregunta'");
	$cant      = mysqli_num_rows($verificar);

	$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM preguntas");
	$row_folio = mysqli_fetch_array($cadena_folio);
	
	if($row_folio[0] == ""){
		$folio = 0;
	}
	else{
		$folio = $row_folio[0] + 1;
	}

	if($cant == 0){
		for ($i=0; $i < $cantidad ; $i++) { 
			$cadena = mysqli_query($conexion,"INSERT INTO preguntas (folio,pregunta,id_departamento,id_categoria,tipo_pregunta,id_usuario,fecha,hora,activo) 
				VALUES('$folio','$pregunta','$departamento[$i]','$categoria','$tipo_pregunta','$id_usuario','$fecha','$hora','1')");
		}
		echo "ok";
	}
	else{
		echo "duplicado";
	}
?>