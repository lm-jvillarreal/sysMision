<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('h:i:s');

	$cantidad      = "";
	$id_registro     = $_POST['id_registro'];
	$id_persona = $_POST['id_persona'];
	$departamento  = $_POST['departamento'];
	$sucursal  = $_POST['sucursal'];
	$puesto    = $_POST['puesto'];
	$permisos   =$_POST['permisos'];
	$cantidad      = count($permisos);

	$f_nombre = $_FILES["archivos"]['name'];
	$f_tamano = $_FILES["archivos"]['size']; 
	$f_tipo = $_FILES["archivos"]['type'];

	$ext = explode(".", $_FILES['archivos']['name']);
	$extension = end($ext);


	for ($i=0; $i <$cantidad; $i++)
	{
		$cadenaUno = "SELECT id_permiso FROM firmas_autorizadas WHERE nombre = '$id_persona' AND id_permiso = '$permisos[$i]'";
		$verificar = mysqli_query($conexion, $cadenaUno);

		$cant      = mysqli_num_rows($verificar);
		if ($cant==0) 
		{
			$cadena= mysqli_query($conexion,"INSERT INTO firmas_autorizadas(nombre, departamento, sucursal, puesto, id_permiso, activo)
			VALUES ('$id_persona', '$departamento','$sucursal', '$puesto', '$permisos[$i]','1')");

			//Copia de firma
			$cadena_maximo = "SELECT MAX(id) FROM firmas_autorizadas";
			$consulta_maximo = mysqli_query($conexion, $cadena_maximo);
			$row_maximo = mysqli_fetch_array($consulta_maximo);
			$destino = "firmas/".$row_maximo[0].".".$extension;
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