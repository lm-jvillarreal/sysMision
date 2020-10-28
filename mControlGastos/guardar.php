<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre_rancho    = $_POST['nombre_rancho'];
	$nombre_rancho    = trim($nombre_rancho);
	$tipo_rancho      = $_POST['tipo_rancho'];
	$estado           = $_POST['estado'];
	$municipio        = $_POST['municipio'];
	$encargado_rancho = $_POST['encargado_rancho'];
	$encargado_rancho = trim($encargado_rancho);
	$id_rancho        = $_POST['id_rancho'];

	if($nombre_rancho == "" || $tipo_rancho == "" || $estado == "" || $municipio == "" || $encargado_rancho == ""){
		echo "vacio";
		return false;
	}

	if($id_rancho == 0){
		$verificar = mysqli_query($conexion,"SELECT id FROM ranchos WHERE nombre_rancho = '$nombre_rancho' AND estado = '$estado' AND tipo = '$tipo_rancho' AND activo = '1'");
		$existe = mysqli_num_rows($verificar);
		if($existe == 0){
			$cadena = mysqli_query($conexion,"INSERT INTO ranchos (nombre_rancho,tipo,estado,municipio,encargado,fecha,hora,activo,id_usuario) VALUES ('$nombre_rancho','$tipo_rancho','$estado','$municipio','$encargado_rancho','$fecha','$hora','1','$id_usuario')");
			echo "ok";
		}else{
			echo "duplicado";
		}
	}else{
		$cadena = mysqli_query($conexion,"UPDATE ranchos SET nombre_rancho = '$nombre_rancho', tipo = '$tipo_rancho', estado = '$estado', municipio = '$municipio', encargado = '$encargado_rancho', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_rancho'");
		echo "ok";
	}
?>
