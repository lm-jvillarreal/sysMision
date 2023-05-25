<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $equipo      = $_POST['equipo'];

	if ($id_registro == 0){
		$cadena_verificar = mysqli_query($conexion,"SELECT id FROM tipos_equipos WHERE activo = '1' AND nombre = '$equipo'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
            $cadena = "INSERT INTO tipos_equipos (nombre, descripcion,fecha, hora, usuario, activo ) VALUES ('$equipo','','$fecha','$hora','$id_usuario','1')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = "UPDATE tipos_equipos SET nombre = '$equipo', fecha = '$fecha', hora = '$hora', usuario = '$id_usuario' WHERE id_tipo = '$id_registro'";
		$update= mysqli_query($conexion,$actualizar);
		echo "ok_actualizado";
	}
?>