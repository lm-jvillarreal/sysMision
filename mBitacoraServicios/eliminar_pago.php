<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pago = $_POST['id_pago'];

	$cadena = mysqli_query($conexion,"UPDATE pagos_servicios SET activo = '0' WHERE id = '$id_pago'");
	$cadena = mysqli_query($conexion,"UPDATE detalle_pago_servicios SET activo = '0' WHERE id_pago = '$id_pago'");
	
	echo "ok";
?>