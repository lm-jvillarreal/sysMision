<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre       = $_POST['nombre'];
	$sucursal     = $_POST['sucursal'];
	$departamento = $_POST['departamento'];
	$categoria    = $_POST['categoria'];
	$calificar    = $_POST['calificar'];
	$perfil       = $_POST['perfil'];
	$id_registro  = $_POST['id_registro'];

	if($id_registro == 0){
		$verificar=mysqli_query($conexion,"SELECT id FROM checklist WHERE nombre = '$nombre' AND id_sucursal = '$sucursal' AND id_departamento = '$departamento' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO checklist(nombre,id_departamento,id_categoria,id_sucursal,tipo,id_perfil, fecha,hora,id_usuario,activo)
						VALUES('$nombre','$departamento','$categoria','$sucursal','$calificar','$perfil','$fecha','$hora','$id_usuario','1')");
			echo "ok";
		}
		else{
			echo "duplicado";
		}
	}else{
		$cadena = mysqli_query($conexion,"UPDATE checklist SET nombre = '$nombre', id_departamento = '$departamento', id_categoria = '$categoria', id_sucursal = '$sucursal', tipo = '$calificar', id_perfil = '$perfil' WHERE id = '$id_registro'");
		echo "ok";
	}
?>
