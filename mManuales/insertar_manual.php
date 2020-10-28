<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$nombre      = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$id_registro = $_POST['id_registro'];
	$categoria   = $_POST['categoria'];

	if ($id_registro == 0){

		$verificar = mysqli_query($conexion,"SELECT id FROM manuales WHERE nombre = '$nombre' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);

		if ($existe == 0){

			$cadena = "INSERT INTO manuales (nombre,descripcion,categoria,fecha,hora,id_usuario,activo)
			VALUES('$nombre','$descripcion','$categoria','$fecha','$hora','$id_usuario','1')";
			$consulta = mysqli_query($conexion,$cadena);

			$consulta = mysqli_query($conexion,"SELECT MAX(id) FROM manuales");
			$row = mysqli_fetch_array($consulta);

			if(!empty($_FILES['manual']['name'])){
				$tamano      = $_FILES["manual"]['size'];
				$tipo        = $_FILES["manual"]['type'];
				$archivo     = $_FILES["manual"]['name'];
				$ruta =  "manuales/".$row[0].".pdf";
				if (copy($_FILES['manual']['tmp_name'],$ruta)) {
					$status = "Archivo subido: <b>".$archivo."</b>";
			    }else {
			        $status = "Error al subir el archivo";
			    }
			    $subir = mysqli_query($conexion,"UPDATE manuales SET ruta = '$ruta' WHERE id = '$row[0]'");
				echo "ok";
			}
		}
		else{
			echo "duplicado";
		}
	}
	else{
		$actualizar  = mysqli_query($conexion,"UPDATE manuales SET nombre = '$nombre', descripcion = '$descripcion', categoria = '$categoria', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		if(!empty($_FILES['manual']['name'])){
			$tamano      = $_FILES["manual"]['size'];
			$tipo        = $_FILES["manual"]['type'];
			$archivo     = $_FILES["manual"]['name'];
			$ruta =  "manuales/".$id_registro.".pdf";
			if (copy($_FILES['manual']['tmp_name'],$ruta)) {
				$status = "Archivo subido: <b>".$archivo."</b>";
		    }else {
		        $status = "Error al subir el archivo";
		    }
		    $subir = mysqli_query($conexion,"UPDATE manuales SET ruta = '$ruta' WHERE id = '$id_registro'");
		}
		echo "ok";
	}
?>