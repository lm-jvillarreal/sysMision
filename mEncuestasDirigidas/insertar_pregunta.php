<?php
	// include 'simplexlsx.class.php';
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$folio_encuesta = $_POST['folio_encuesta'];
	$pregunta = $_POST['pregunta'];
	$pregunta = trim($pregunta);

	if($pregunta != ""){
		$cadena_verificar = mysqli_query($conexion,"SELECT id FROM s_encuestas WHERE pregunta = '$pregunta' AND folio ='$folio_encuesta' AND activo = '1'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO s_encuestas (folio,pregunta,fecha,hora,activo,id_usuario)
				VALUES ('$folio_encuesta','$pregunta','$fecha','$hora','1','$id_usuario')");
			echo "ok";
		}else{
			echo"duplicado";
		}
	}else{
		echo "vacio";
	}
?>