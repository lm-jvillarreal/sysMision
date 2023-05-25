<?php
	include '../global_seguridad/verificar_sesion.php';
    
    $id_registro = $_POST['id_registro'];
    $id_caja    = $_POST['id_caja'];
    $id_equipo = $_POST['id_equipo'];
    $descripcion = $_POST['descripcion'];

	if ($id_registro == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM reportes_cajas WHERE activo = '1' AND status = '1' AND id_caja = '$id_caja' AND id_equipo = '$id_equipo'");
		$existe = mysqli_num_rows($cadena_verificar);
		if($existe == 0){
			$consulta = "INSERT INTO reportes_cajas (id_caja, id_equipo, falla, status, activo, fecha, hora, id_usuario) VALUES ('$id_caja','$id_equipo','$descripcion','1','1','$fecha','$hora','$id_usuario')";
			$cadena = mysqli_query($conexion,$consulta);
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$actualizar  = mysqli_query($conexion,"UPDATE reportes_cajas SET falla = '$descripcion', id_caja = '$id_caja', id_equipo = '$id_equipo', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'");
		echo "ok";
	}
?>