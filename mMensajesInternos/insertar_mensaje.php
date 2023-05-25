<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');
	$fechahora=date("Y-m-d H:i:s");

	$cantidad      = "";
	$id_registro   = $_POST['id_registro'];
	$mensaje       = $_POST['nuevo_mensaje'];
	$Compras       = $_POST['destinos'];
    $area          = $_POST['area'];
	$sucursal      = $_POST['sucursal'];
	$cantidad      = count($Compras);


	for ($i=0; $i <$cantidad; $i++)
	{
		$cadenaUno = "SELECT id FROM mensajes WHERE mensaje = '$mensaje' AND destinatario = '$Compras[$i]'";
		$verificar = mysqli_query($conexion, $cadenaUno);

		$cant      = mysqli_num_rows($verificar);
		if ($cant==0) 
		{
			$cadenaInsertar= "INSERT INTO mensajes (sucursal, mensaje, imagen, audio, destinatario, area, id_usuario, fecha, hora, activo, estatus)
			VALUES ('$id_sede','$mensaje', '', '','$Compras[$i]','$area','$id_usuario','$fecha','$hora', '1', '0')";
			$Consulta_Insertar = mysqli_query($conexion, $cadenaInsertar);
			//echo  $cadenaInsertar;
			//Copia de firma

			$cadena_maximo = "SELECT MAX(id) FROM mensajes";
			$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
			$row_maximo = mysqli_fetch_array($consulta_maximo);
			echo "ok";
				$cadena_agenda                = "";//consulta para insertar en la taba agenda
				$fecha_completa_inicio = "";       //fecha inicial para insertar en agenda
				$fecha_completa_final  = "";       //fecha final para insertar en agenda
				$color = "#C39BD3";                //color para insertar en agenda
				$fecha_nueva = date($fecha);
				$nuevafecha  = strtotime ( '+1 day' , strtotime ( $fecha_nueva ) ) ;
				$nuevafecha  = date ( 'Y-m-d' , $nuevafecha );


				$cadena_notificacion = mysqli_query($conexion,"SELECT id,destinatario
				FROM mensajes
				WHERE id = '$id_registro'");
				$row_notificacion = mysqli_fetch_array($cadena_notificacion);

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

  				$title = sanear_string($nombre);
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
				$add ="Nuevo Mensaje: ";
				$title = $add.' '.$sucu;

    			$fecha_completa_inicio = $fecha .' 12:00:00';
    			$fecha_completa_final  = $nuevafecha .' 12:00:00';

    			$cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
    			$row_folio    = mysqli_fetch_array($cadena_folio);
    			$folio        = $row_folio[0] + 1;

    			$cadena_eventos = mysqli_query($conexion,"SELECT usuarios.id,usuarios.nombre_usuario
                        FROM usuarios
                        INNER JOIN personas ON personas.id = usuarios.id_persona
                        WHERE
        				personas.id_sede = '$id_sede' 
         				AND  usuarios.id = '161' AND usuarios.id = '2'");
						// usuarios.activo = '1' 
						// AND usuarios.id_perfil = '2' 
						// OR usuarios.id = '2' 
						// OR
                        		 //  personas.id_sede = '$id_sede' AND usuarios.id_perfil = '2' OR  usuarios.id = '2'OR 
      			while($row_e = mysqli_fetch_array($cadena_eventos)){
          			$cadena_agenda = mysqli_query($conexion,"INSERT INTO agenda (folio,title,start,end,id_usuario,fecha,hora,backgroundColor,borderColor)
      				VALUES ('$folio','$title','$fecha_completa_inicio','$fecha_completa_final','$row_e[0]','$fecha','$hora','$color','$color')");
					echo $Compras[$i];
      			}
		}
		else {
			echo "Duplicado";
		}
   
	}
?>