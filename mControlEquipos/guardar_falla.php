<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $falla    = $_POST['falla'];

	if ($id_registro == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM fallas_equipos WHERE activo = '1' AND nombre = '$falla'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
			$consulta = mysqli_query($conexion,"INSERT INTO fallas_equipos (nombre, activo, fecha, hora, id_usuario) VALUES ('$falla','1','$fecha','$hora','$id_usuario')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = mysqli_query($conexion,"UPDATE fallas_equipos SET nombre = '$falla', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>