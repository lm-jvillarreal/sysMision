<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_sub_departamento = $_POST['id_sub_departamento'];
	$sub_departamento    = $_POST['sub_departamento'];

	if($id_sub_departamento == 0){
		$verificar=mysqli_query($conexion,"SELECT id FROM sub_departamentos WHERE nombre = '$sub_departamento' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO sub_departamentos (nombre,fecha,hora,id_usuario,activo)
						VALUES('$sub_departamento','$fecha','$hora','$id_usuario','1')");
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}else{
		$cadena = mysqli_query($conexion,"UPDATE sub_departamentos SET nombre = '$sub_departamento', fecha = '$fecha', hora = '$hora' WHERE id = '$id_sub_departamento'");
		echo "ok";
	}
?>
