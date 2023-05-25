<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$cantidad      = "";
	$id_registro   = $_POST['id_registro'];
	$mensaje    = $_POST['nuevo_mensaje'];
	$destinatario  = $_POST['destinos'];
	$cantidad      = count($destinatario);

	$f_nombre = $_FILES["archivos"]['name'];
	$f_tamano = $_FILES["archivos"]['size']; 
	$f_tipo   = $_FILES["archivos"]['type'];

	$ext = explode(".", $_FILES['archivos']['name']);
	$extension = end($ext);

	for ($i=0; $i <$cantidad; $i++)
	{
		$cadenaUno = "SELECT id FROM mensajes WHERE mensaje = '$mensaje' AND destinos = '$destinatario[$i]'";
		$verificar = mysqli_query($conexion, $cadenaUno);

		$cant      = mysqli_num_rows($verificar);
		if ($cant==0) 
		{
			$cadena= mysqli_query($conexion,"INSERT INTO mensajes(mensaje, imagen, audio, destinatario, usuario, fecha, hora, activo)
			VALUES ('$mensaje', 'null','null','$destinatario[$i]','$usuario','$fecha','$hora','1')");

			//Copia de firma
			$cadena_maximo = "SELECT MAX(id) FROM mensajes";
			$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
			$row_maximo = mysqli_fetch_array($consulta_maximo);
			$destino = "mensajes/".$row_maximo[0].".".$extension;
			if (copy($_FILES['archivos']['tmp_name'],$destino)) 
			{ 
				$status = "Archivo subido"; 
			}  
			else  
			{ 
				$status = "Error al subir el archivo"; 
			} 
		//
		}
		else {
		}
	}
	echo "ok";
?>