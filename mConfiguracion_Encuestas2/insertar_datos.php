<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$id_encuesta            = $_POST['id_encuesta_modal'];
	$id_encuesta_trabajador = $_POST['id_encuesta_trabajador'];

	$cadena   = mysqli_query($conexion,"SELECT id FROM n_preguntas WHERE folio = '$id_encuesta'");
	$cantidad = mysqli_num_rows($cadena);

	$o = 1;
	while($row = mysqli_fetch_array($cadena)){
		$respuesta = $_POST["respuesta".$o];		
		$cadena2 = mysqli_query($conexion,"INSERT INTO n_resultados (folio_encuesta,id_pregunta,respuesta,id_persona,fecha,hora,activo,id_usuario)
			VALUES ('$id_encuesta','$row[0]','$respuesta','$id_encuesta_trabajador','$fecha','$hora','1','$id_usuario')");
		$o++;
	}
	echo "ok";
?>