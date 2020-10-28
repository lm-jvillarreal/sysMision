<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $sucursal    = $_POST['sucursal'];
    $caja        = $_POST['caja'];
    $equipo      = $_POST['id_equipo'];

	if ($id_registro == 0){
		$cadena_verificar = mysqli_query($conexion,"SELECT id FROM detalle_caja WHERE activo = '1' AND id_equipo = '$equipo' AND id_caja = '$caja'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
			$cadena = "INSERT INTO detalle_caja (id_caja, id_equipo, tipo, activo, fecha, hora, id_usuario) VALUES ('$caja','$equipo','1','1','$fecha','$hora','$id_usuario')";
			$consulta = mysqli_query($conexion,$cadena);
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = mysqli_query($conexion,"UPDATE detalle_caja SET id_equipo = '$equipo', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>