<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_cotizacion = $_POST['id_cotizacion'];
	$id_proveedor  = $_POST['id_proveedor'];
	$id_concepto   = $_POST['id_concepto'];
	$costo         = $_POST['costo'];
	$calidad       = $_POST['calidad'];

	if($calidad == "Buena"){
		$calidad = "10";
	}else if($calidad == "Regular"){
		$calidad = "5";
	}else{
		$calidad = "0";
	}
	
	$cadena_v = mysqli_query($conexion,"SELECT id FROM detalle_cotizacion WHERE id_concepto = '$id_concepto' AND id_proveedor = '$id_proveedor'");
	$existe   = mysqli_num_rows($cadena_v);
	if($existe == 0){
		$cadena = mysqli_query($conexion,"INSERT INTO detalle_cotizacion (id_cotizacion,id_concepto, id_proveedor, costo, calidad, fecha, hora, activo, id_usuario) VALUES('$id_cotizacion','$id_concepto','$id_proveedor','$costo','$calidad','$fecha','$hora','1','$id_usuario')");
	}else{
		$cadena = mysqli_query($conexion,"UPDATE detalle_cotizacion SET costo = '$costo', calidad = '$calidad' WHERE id_concepto = '$id_concepto' AND id_proveedor = '$id_proveedor'");
	}

	echo "ok";
?>