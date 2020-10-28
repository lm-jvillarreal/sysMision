<?php
	include '../global_seguridad/verificar_sesion.php';
	if(!empty($_FILES['archivo']['name']) || !empty($_POST['descripcion'])){
		$tamano  = $_FILES["archivo"]['size'];
		$tipo    = $_FILES["archivo"]['type'];
		$archivo = $_FILES["archivo"]['name'];

		$descripcion = $_POST['descripcion'];
		$descripcion = trim($descripcion);
		if($descripcion == ""){
			echo "vacio";
			return false;
		}

		$destino =  "archivos/text.txt";
		if (copy($_FILES['archivo']['tmp_name'],$destino)) 
	    {
	        $status = "Archivo subido: <b>".$archivo."</b>";
	        $file = fopen($destino, "r") or exit("Unable to open file!");
	        $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM control_gastos");
	        $row_folio = mysqli_fetch_array($cadena_folio);
	        $folio = ($row_folio[0] == "")?1:$row_folio[0] + 1;
	        $cadena = mysqli_query($conexion,"INSERT INTO control_gastos (folio,descripcion,fecha,hora,activo,id_usuario) VALUES ('$folio','$descripcion','$fecha','$hora','1','$id_usuario')");
			$loop = 0; // contador de líneas

			while (!feof($file)) { // loop hasta que se llegue al final del archivo
				$loop++;
				$line = fgets($file); // guardamos toda la línea en $line como un string
				if(empty($line)){ //verificamos si la cadena es vacia.
					continue;	
				}else{
					// dividimos $line en sus celdas, separadas por el caracter |
					// e incorporamos la línea a la matriz $field
					$field[$loop] = explode ('~', $line);
					// generamos la salida HTML
					if($loop == 1){
						continue;
					}else{
						$uuid                    = $field[$loop][0];
						$rfc_emisor              = $field[$loop][1];
						$nombre_emisor           = $field[$loop][2];
						$rfc_receptor            = $field[$loop][3];
						$nombre_receptor         = $field[$loop][4];
						$rfc_pac                 = $field[$loop][5];
						$fecha_emision           = $field[$loop][6];
						$fecha_certificacion_sat = $field[$loop][7];
						$monto                   = $field[$loop][8];
						$efecto_comprobante      = $field[$loop][9];
						$estatus                 = $field[$loop][10];
						$fecha_cancelacion       = $field[$loop][11];

						//Verificamos si en fecha de cancelacion existe fecha, si no, se utiliza un valor null.
						
						$cadena =  mysqli_query($conexion,"INSERT INTO detalle_control_gastos (folio, uuid, rfc_emisor, nombre_emisor, rfc_receptor, nombre_receptor, rfc_pac, fecha_emision, fecha_certificacion_sat, monto, efecto_comprobante, estatus, fecha_cancelacion, fecha, hora, activo, id_usuario)
						VALUES ('$folio','$uuid','$rfc_emisor','$nombre_emisor','$rfc_receptor','$nombre_receptor','$rfc_pac','$fecha_emision','$fecha_certificacion_sat','$monto','$efecto_comprobante','$estatus',".($fecha_cancelacion != '' ? "NULL" : "'$fecha_cancelacion'").",'$fecha','$hora','1','$id_usuario')");
					}
				}
				$file++; // necesitamos llevar el puntero del archivo a la siguiente línea
			}
			echo "ok";
			fclose($file); //Cerramos el archivo.
	    } 
	    else 
	    {
	        $status = "Error al subir el archivo";
	    }
	}else{
		echo "vacio";
	}
?>