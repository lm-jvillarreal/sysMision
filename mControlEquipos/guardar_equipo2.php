<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $equipo      = $_POST['equipo'];
    $descripcion = $_POST['descripcion'];

	if ($id_registro == 0){
		$cadena_verificar = mysqli_query($conexion,"SELECT id FROM cajas_catalogo_equipos WHERE activo = '1' AND nombre = '$equipo'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
            $cadena = "INSERT INTO cajas_catalogo_equipos (nombre, descripcion, activo, fecha, hora, id_usuario) VALUES ('$equipo','$descripcion','1','$fecha','$hora','$id_usuario')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = mysqli_query($conexion,"UPDATE cajas_catalogo_equipos SET nombre = '$equipo', descripcion = '$descripcion', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>