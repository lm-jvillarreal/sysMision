<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');
	
	$id               = $_POST['id'];
	$folio            = $_POST['folio'];
	$nombre           = $_POST['nombre'];
	$fecha_inicio     = $_POST['fecha_inicio'];
	$fecha_fin        = $_POST['fecha_fin'];
	$cantidad         = $_POST['cantidad'];
	$cadena_preguntas = "";
	$cadena_sucursal  = "";

	if(isset($_POST['preguntas']) && isset($_POST['sucursal'])){

		$preguntas          = $_POST['preguntas'];
		$cantidad_preguntas = count($preguntas);
		
		$sucursal            = $_POST['sucursal'];
		$cantidad_sucursales = count($sucursal);

		//////////////////////////////////////ELIMINAR/////////////////////////////
		
		for ($i=0; $i < $cantidad_preguntas ; $i++) {
			
			$cadena_preguntas .= " "."AND id_pregunta !='".$preguntas[$i]."'";
		}

		for ($o=0; $o < $cantidad_sucursales ; $o++) {
			
			$cadena_sucursal .= " "."AND id_sucursal !='".$sucursal[$o]."'";
		}

		$cadena = mysqli_query($conexion,"SELECT id FROM encuestas WHERE folio_cuestionario = '$folio'".$cadena_preguntas);
		while ($row_cadena = mysqli_fetch_array($cadena)) {
			$cadena1 = mysqli_query($conexion,"UPDATE encuestas SET activo = '0' WHERE id = '$row_cadena[0]'");
		}

		//////////////////////////////////////ELIMINAR/////////////////////////////

		//////////////////////////////////////ÀÑADIR/////////////////////////////

		for ($e=0; $e < $cantidad_preguntas ; $e++) { 
			$cadena2 = mysqli_query($conexion,"SELECT * FROM encuestas WHERE folio_cuestionario = '$folio' AND id_pregunta = '$preguntas[$e]'");
			$cant = mysqli_num_rows($cadena2);
			if($cant == 0){
				$cadena3 = mysqli_query($conexion,"INSERT INTO encuestas (folio_cuestionario,id_pregunta,fecha,hora,id_usuario,activo)
													VALUES ('$folio','$preguntas[$e]','$fecha','$hora','$id_usuario','1')");
			}
		}

		//////////////////////////////////////ÀÑADIR/////////////////////////////
		// echo "SELECT id FROM cuestionarios WHERE folio = '$folio'".$cadena_sucursal;
		$cadena11 = mysqli_query($conexion,"SELECT id FROM cuestionarios WHERE folio = '$folio'".$cadena_sucursal);
		while ($row_cadena1 = mysqli_fetch_array($cadena11)) {
			$cadena1 = mysqli_query($conexion,"UPDATE cuestionarios SET activo = '0' WHERE id = '$row_cadena1[0]'");
		}

		//////////////////////////////////////ÀÑADIR/////////////////////////////

		for ($a=0; $a < $cantidad_sucursales ; $a++) { 
			$cadena4 = mysqli_query($conexion,"SELECT * FROM cuestionarios WHERE folio = '$folio' AND id_sucursal = '$sucursal[$a]'");
			$cant = mysqli_num_rows($cadena4);
			if($cant == 0){
				$cadena5 = mysqli_query($conexion,"INSERT INTO cuestionarios (folio,nombre,encuestados,id_sucursal,cantidad_encuestados,fecha_inicio,fecha_fin,fecha,hora,id_usuario,activo)
					VALUES ('$folio','$nombre','0','$sucursal[$a]','$cantidad','$fecha_inicio','$fecha_fin','$fecha','$hora','$id_usuario','1')");
			}
		}

		//////////////////////////////////////ÀÑADIR/////////////////////////////



		///////////////////ACTUALIZAR//////////////////////////
		$actualizar = mysqli_query($conexion,"UPDATE cuestionarios SET nombre = '$nombre',cantidad_encuestados = '$cantidad',fecha_inicio = '$fecha_inicio',fecha_fin = '$fecha_fin',fecha = '$fecha',hora = '$hora',id_usuario = '$id_usuario' WHERE folio = '$folio'");

		echo "ok";
	}
	else{
		echo "Verifica";
	}







	// $consulta = mysqli_query($conexion,"UPDATE cuestionarios SET nombre = '$nombre', cantidad_encuestados = '$cantidad',fecha_inicio = '$fecha_inicio',fecha_fin = '$fecha_fin',fecha = '$fecha',hora ='$hora',id_usuario = '$id_usuario' WHERE id = '$id'");

	// for ($i=0; $i < $cantidad_preguntas; $i++) { 
		
	// 	$cadena = mysqli_query($conexion,"INSERT INTO encuestas (id_cuestionario,id_pregunta,fecha,hora,id_usuario,activo)
	// 				VALUES ('$id','$preguntas[$i]','$fecha','$hora','$id_usuario','1')");
	//}
// ?>