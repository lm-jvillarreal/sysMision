<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre           = $_POST['nombre'];
	$fecha_cotizacion = $_POST['fecha_cotizacion'];
	$sucursal         = $_POST['sucursal'];
	$id_cotizacion    = $_POST['id_cotizacion'];

	if($id_cotizacion == 0){
		$consulta = mysqli_query($conexion,"INSERT INTO cotizaciones (nombre,fecha_cotizacion,fecha,hora,activo,id_usuario,id_sucursal) VALUES ('$nombre','$fecha_cotizacion','$fecha','$hora','1','$id_usuario','$sucursal')");
		$cadena  = mysqli_query($conexion,"SELECT MAX(id) FROM cotizaciones");
		$row     = mysqli_fetch_array($cadena);
		$mensaje = "ok";
		$array   = array($mensaje,$row[0]);
		echo json_encode($array);
	}else{
		$cadena = mysqli_query($conexion,"UPDATE cotizaciones SET nombre = '$nombre', fecha_cotizacion = '$fecha_cotizacion', id_sucursal = '$sucursal', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_cotizacion'");
		$mensaje = "ok2";
		$array   = array($mensaje,$id_cotizacion);
		echo json_encode($array);
	}
?>