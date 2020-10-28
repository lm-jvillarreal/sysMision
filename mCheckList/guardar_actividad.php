<?php
	include '../global_seguridad/verificar_sesion.php';

	$actividad        = $_POST['actividad'];
	$sub_departamento = $_POST['sub_departamento'];
	$checklist        = $_POST['checklist'];
	$id_registro      = $_POST['id_registro'];

	if($id_registro == 0){
		$verificar=mysqli_query($conexion,"SELECT id FROM detalle_checklist WHERE nombre = '$actividad' AND id_subdepartamento = '$sub_departamento' AND id_checklist = '$checklist' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO detalle_checklist (nombre, id_checklist, id_subdepartamento,programada, fecha,hora,id_usuario,activo)
						VALUES('$actividad','$checklist','$sub_departamento','0','$fecha','$hora','$id_usuario','1')");
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}else{
		$cadena = mysqli_query($conexion,"UPDATE detalle_checklist SET nombre = '$actividad', id_checklist = '$checklist', id_subdepartamento = '$sub_departamento' WHERE id = '$id_registro'");
		echo "ok";
	}
?>
