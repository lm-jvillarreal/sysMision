<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $ideeCaja   = $_POST['ideeCaja'];
    $ideeEquipo = $_POST['ideeEquipo'];
	$ideFalla = $_POST['ideFalla'];
	$seleccionado = $_POST['seleccionado'];
	$cantidad     =count('ideeFalla');

	$elegir       = "";

	if($id_registro == 0)
	{
	 	$verificar = mysqli_query($conexion, "SELECT id FROM reportes_cajas WHERE id_caja='$ideeCaja' AND id_equipo = '$ideeEquipo' AND id_falla = '$ideFalla' AND status = '1'");
	 	$existe = mysqli_num_rows($verificar);
		
	 	if($existe == 0){
			$cadena_reporte = "INSERT INTO reportes_cajas (id_caja, id_equipo, id_falla, status, activo, fecha, hora, id_usuario, id_sucursal) VALUES ('$ideeCaja','$ideeEquipo','$ideFalla','1','1','$fecha','$hora','$id_usuario','$id_sede')";
			$cadena_consulta = mysqli_query($conexion,$cadena_reporte);
			echo "ok";
			         /////////////////////////notificaciones///////////////////////////////////////////////
			$cadena_agenda                = "";//consulta para insertar en la taba agenda
			$fecha_completa_inicio = "";       //fecha inicial para insertar en agenda
			$fecha_completa_final  = "";       //fecha final para insertar en agenda
			$color = "#4BABA8";                //color para insertar en agenda  #6CF9EA
			$fecha_nueva = date($fecha);
			$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
			$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );

    		$cadena_incidencias = mysqli_query($conexion,"SELECT nombre
                   FROM cajas
                   WHERE id = '$ideeCaja'");
 			$row_incidencias = mysqli_fetch_array($cadena_incidencias);    

			function sanear_string($string)
			{
				$string = trim($string);
				$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
					$string
				);
				$string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
					$string
				);
				$string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
					$string
				);
				$string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
					$string
				);
				$string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
					$string
				);
				$string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C',),
					$string
				);
				return $string;
			}

			$title = sanear_string($row_incidencias[0]);
			if($id_sede == "1"){
				$sucu = "D.O";
			}else if($id_sede == "2"){
				$sucu = "ARB.";
			}else if ($id_sede == "3"){
				$sucu = "VILL.";
			}else if($id_sede == "4"){
				$sucu = "ALL.";
			}else{
				$sucu = "PET.";
			}
			$add ="REPORTE CAJA: ";
			$title = $add.'-'.$title.'-'.$sucu;

			$fecha_completa_inicio = $fecha .' 12:00:00';
			$fecha_completa_final  = $nuevafecha .' 12:00:00';

			$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
			$row_folio    = mysqli_fetch_array($cadena_folio);
			$folio        = $row_folio[0] + 1;

			$cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
			FROM usuarios
			INNER JOIN personas ON personas.id = usuarios.id_persona
			WHERE usuarios.id = '2' OR usuarios.id = '36' OR usuarios.id = '161'");
			//colocar la linea de personas despues del where al finalOR usuarios.id = '49'//
			while($row_e = mysqli_fetch_array($cadena_eventos)){
				$cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
				VALUES ('$folio','$title','$fecha_completa_inicio','$fecha_completa_final','$row_e[0]','$fecha','$hora','$color','$color')");
			}
		/////////////////////////////////////////notificaciones////////////////////////////////////////////////////////
		}else{
			echo "actualizado";
		}
	}
?>