<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$id_cotizacion = $_POST['id_cotizacion_conceptos'];
	$concepto      = $_POST['concepto'];
	$id_concepto   = $_POST['id_concepto'];

	if($id_concepto == 0){
		$cadena = mysqli_query($conexion,"SELECT id FROM conceptos_cotizacion WHERE id_cotizacion = '$id_cotizacion' AND nombre = '$concepto'");
		$existe = mysqli_num_rows($cadena);
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO conceptos_cotizacion (id_cotizacion, nombre, fecha, hora, activo, id_usuario) 
				VALUES ('$id_cotizacion', '$concepto','$fecha','$hora','1','$id_usuario')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$cadena = mysqli_query($conexion,"UPDATE conceptos_cotizacion SET nombre = '$concepto', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_concepto'");
		echo "ok2";
	}
?>
