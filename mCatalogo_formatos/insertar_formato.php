<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$id_registro = $_POST['id_registro'];
	$nombre     = $_POST['nombre'];
	
	$f_nombre = $_FILES["archivos"]['name'];
	$f_tamano = $_FILES["archivos"]['size']; 
	$f_tipo = $_FILES["archivos"]['type'];

	$ext = explode(".", $_FILES['archivos']['name']);
	$extension = end($ext);

	
	if (empty($id_registro)) {
		//Insertar nuevo registro
		$verificar=mysqli_query($conexion,"SELECT id FROM catalogo_formatos WHERE id= '$id_registro'");
		$existe = mysqli_num_rows($verificar);
		// $cant      = mysqli_num_rows($existe);
		if ($existe == 0) 
		{
			$cadena= "INSERT INTO catalogo_formatos( nombre, fecha, hora, activo, usuario)
			VALUES ('$nombre', '$fecha','$hora','1','1')";

			$consulta = mysqli_query($conexion,$cadena);
			
			//Copia de firma
			$cadena_maximo = "SELECT MAX(id) FROM catalogo_formatos";
			$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
			$row_maximo = mysqli_fetch_array($consulta_maximo);
			$destino = "formatos/".$row_maximo[0].".".$extension;
			if (copy($_FILES['archivos']['tmp_name'],$destino)) 
			{ 
				$status = "Archivo subido"; 
				echo "ok_nuevo";
			}  
			else  
			{ 
				$status = "Error al subir el archivo"; 	
			} 
		}
	}
		else {
		}
?>