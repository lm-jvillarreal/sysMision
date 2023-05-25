<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $falla    = $_POST['falla'];
	$equipo   = $_POST['equipo'];

	if ($id_registro == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM fallas_equipos WHERE activo = '1' AND nombre = '$falla'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
			$consulta = "INSERT INTO fallas_equipos (nombre, equipo, activo, fecha, hora, id_usuario) VALUES ('$falla','$equipo','1','$fecha','$hora','$id_usuario')";
			$insertar = mysqli_query($conexion,$consulta);
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = mysqli_query($conexion,"UPDATE fallas_equipos SET nombre = '$falla', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>