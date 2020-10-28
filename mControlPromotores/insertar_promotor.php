<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("H:i:s");

	$nombre      = $_POST['nombre'];
	$ap_paterno  = $_POST['ap_paterno'];
	$compañia    = $_POST['compañia'];
	$telefono    = $_POST['telefono'];
	$frecuencia  = $_POST['frecuencia'];
	$comprador   = $_POST['comprador'];
	$proveedor   = $_POST['proveedor'];
	$id_registro = $_POST['id_registro'];
	$mensaje     = "";
	$id_promotor = 0;

	if (isset($_POST['celular'])) {
		$celular = $_POST['celular'];
	}else{
		$celular = "";
	}
	if($celular == "on"){
		$celular = "1";
	}else{
		$celular = "0";
	}

	if ($id_registro == 0){
		$verificar = mysqli_query($conexion,"SELECT id FROM promotores WHERE nombre = '$nombre' AND ap_paterno = '$ap_paterno' AND compañia = '$compañia' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		if ($existe == 0){
			$cadena = "INSERT INTO promotores (nombre,ap_paterno,compañia,fecha,hora,id_usuario,activo,telefono,clave_proveedor,id_comprador,frecuencia,celular)
			VALUES('$nombre','$ap_paterno','$compañia','$fecha','$hora','$id_usuario','1','$telefono','$proveedor','$comprador','$frecuencia','$celular')";
			$consulta = mysqli_query($conexion,$cadena);

			$cadena_promotor = mysqli_query($conexion,"SELECT MAX(id) FROM promotores");
			$row = mysqli_fetch_array($cadena_promotor);
			$id_promotor = ($row[0] != "")?$row[0]:0;

			$cadenaActi = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad, id_promotor, fecha, hora, activo, id_usuario, principal,temporal) VALUES ('# Cajas Surtidas', '$id_promotor','$fecha','$hora','1','$id_usuario','1','0')");
			$mensaje = "ok";
		}
		else{
			$mensaje = "duplicado";
		}
	}
	else{
		$cadena_actualizar = mysqli_query($conexion,"UPDATE promotores SET nombre = '$nombre', ap_paterno = '$ap_paterno',compañia = '$compañia', telefono = '$telefono', clave_proveedor = '$proveedor', id_comprador = '$comprador', frecuencia = '$frecuencia', celular = '$celular' WHERE id = '$id_registro'");
		$mensaje = "ok";
		$id_promotor = 1;
	}
	
	$array = array($mensaje,$id_promotor);
	echo json_encode($array);
?>