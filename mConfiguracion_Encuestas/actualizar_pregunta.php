<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$id            = $_POST['id'];
	$pregunta      = $_POST['pregunta'];
	$folio         = $_POST['folio'];
	$categoria     = $_POST['categoria'];
	$tipo_pregunta = $_POST['tipo_pregunta'];
	$cadena        = "";
	$cadena1       = "";
	$numero        = 0;

	$cadena_dpto = "";

	if(isset($_POST['departamento'])){
		
		$departamento = $_POST['departamento'];
		$cantidad     = count($departamento);

		//////////////////////////////////////ELIMINAR/////////////////////////////
		
		for ($i=0; $i < $cantidad ; $i++) {
			
			$cadena_dpto .= " "."AND id_departamento !='".$departamento[$i]."'";
		}

		$cadena = mysqli_query($conexion,"SELECT id FROM preguntas WHERE folio = '$folio' "."$cadena_dpto");
		while ($row_cadena = mysqli_fetch_array($cadena)) {
			$cadena1 = mysqli_query($conexion,"UPDATE preguntas SET activo = '0' WHERE id = '$row_cadena[0]'");
		}

		//////////////////////////////////////ELIMINAR/////////////////////////////
		for ($o=0; $o < $cantidad ; $o++) { 
			$cadena2 = mysqli_query($conexion,"SELECT * FROM preguntas WHERE folio = '$folio' AND id_departamento = '$departamento[$o]'");
			$cant = mysqli_num_rows($cadena2);
			if($cant == 0){
				$cadena3 = mysqli_query($conexion,"INSERT INTO preguntas (folio,id_categoria,pregunta,id_departamento,tipo_pregunta,id_usuario,fecha,hora,activo)
						VALUES ('$folio','$categoria','$pregunta','$departamento[$o]','$tipo_pregunta','$id_usuario','$fecha','$hora','1')");
			}
		}
		$actualizar = mysqli_query($conexion,"UPDATE preguntas SET id_categoria = '$categoria',pregunta = '$pregunta',tipo_pregunta = '$tipo_pregunta',id_usuario = '$id_usuario',fecha = '$fecha',hora = '$hora' WHERE folio = '$folio'");
		echo "ok";
	}
	else{
		echo "Verifica";
	}


	// for ($i=0; $i < $cantidad ; $i++) { 
	// 	echo $departamento[$i];
	// }


	// $verificar = mysqli_query($conexion,"SELECT id_departamento FROM preguntas WHERE id = '$id'");
	// $row = mysqli_fetch_array($verificar);

	
	// for ($i=0; $i < $cantidad ; $i++) { 
	//  	if ($row[0] == $departamento[$i]){
			// $cadena = mysqli_query($conexion,"UPDATE preguntas SET pregunta = '$pregunta',tipo_pregunta = '$tipo_pregunta',id_categoria = '$categoria' WHERE folio = '$folio'");
	 // 	}
	 // 	else{
	 // 		$cadena1 = mysqli_query($conexion,"INSERT INTO preguntas (folio,pregunta,id_departamento,tipo_pregunta,id_usuario,fecha,hora,activo) 
	 // 			VALUES('$folio','$pregunta','$departamento[$i]','$tipo_pregunta','$id_usuario','$fecha','$hora','1')");
	 // 	}
	 // }
		// echo "ok";
	// $cadena_departamentos_ex = mysqli_query($conexion,"SELECT id_departamento FROM preguntas WHERE folio = '$folio'");
	// 	$cantidad_departamentos = mysqli_num_rows($cadena_departamentos_ex);

	// 	while ($row_departamentos_ex = mysqli_fetch_array($cadena_departamentos_ex)) {
	// 		if($row_departamentos_ex[0] == $departamento[$numero]){
	// 			echo "el mismo";
	// 		}
	// 		else{
	// 			echo "diferente";	
	// 		}
	// 		$numero ++;
	// 	}

?>