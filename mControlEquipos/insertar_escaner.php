<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$marca_e             = $_POST['marca_e'];
	$modelo_e            = $_POST['modelo_e'];
	$serie_e             = $_POST['serie_e'];
	$serie_e             = trim($serie_e);
	$class_no_e          = $_POST['class_no_e'];
	$class_no_e          = trim($class_no_e);
	$fecha_fabricacion_e = $_POST['fecha_fabricacion_e'];
	$serial_no_e         = $_POST['serial_no_e'];
	$serial_no_e         = trim($serial_no_e);
	$id_caja             = $_POST['id_caja_e'];

	$id_registro_e   = $_POST['id_registro_e'];

	if ($id_registro_e == 0){
		$verificar = mysqli_query($conexion,"SELECT id FROM equipos_escaner WHERE no_serial = '$serial_no_e' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		if ($existe == 0){
			$cadena = "INSERT INTO equipos_escaner (id_marca,serie,id_modelo,class_no,fecha_fabricacion,no_serial,id_caja,id_tipo,fecha,hora,id_usuario,activo)
            VALUES('$marca_e','$serie_e','$modelo_e','$class_no_e','$fecha_fabricacion_e','$serial_no_e','$id_caja','2','$fecha','$hora','$id_usuario','1')";
            $consulta = mysqli_query($conexion,$cadena);

            if(!empty($_FILES['archivo_e']['name'])){
                $cadena_id = mysqli_query($conexion,"SELECT MAX(id) FROM equipos_escaner");
                $row_id = mysqli_fetch_array($cadena_id);
                $tamano  = $_FILES["archivo_e"]['size'];
                $tipo    = $_FILES["archivo_e"]['type'];
                $archivo = $_FILES["archivo_e"]['name'];
                $prefijo = "E";

                $destino =  "facturas/".$row_id[0].$prefijo.".pdf";
                if (copy($_FILES['archivo_e']['tmp_name'],$destino)) 
                {
                    $status = "Archivo subido: <b>".$archivo."</b>";
                } 
                else 
                {
                    $status = "Error al subir el archivo";
                }

                $cadena1 = mysqli_query($conexion,"UPDATE equipos_escaner SET ruta = '$destino' WHERE id = '$row_id[0]'");
            }
            echo "ok";
		}
		else{
			echo "duplicado";
		}
	}
	else{
		$actualizar  = mysqli_query($conexion,"UPDATE equipos_escaner SET id_marca = '$marca_e', serie = '$serie_e',id_modelo = '$modelo_e',class_no = '$class_no_e',fecha_fabricacion = '$fecha_fabricacion_e',no_serial = '$serial_no_e', id_caja = '$id_caja', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro_e'");
		if(!empty($_FILES['archivo_e']['name'])){
			$tamano  = $_FILES["archivo_e"]['size'];
			$tipo    = $_FILES["archivo_e"]['type'];
			$archivo = $_FILES["archivo_e"]['name'];
			$prefijo = "E";

			$destino =  "facturas/".$id_registro_e.$prefijo.".pdf";
			if (copy($_FILES['archivo_e']['tmp_name'],$destino)) 
			{
				$status = "Archivo subido: <b>".$archivo."</b>";
			} 
			else 
			{
				$status = "Error al subir el archivo";
			}

			$cadena1 = mysqli_query($conexion,"UPDATE equipos_escaner SET ruta = '$destino' WHERE id = '$id_registro_e'");
		}
		echo "ok";
	}
?>