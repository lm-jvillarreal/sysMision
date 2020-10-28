<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_detalle = $_POST['id_detalle'];

	$cadena = mysqli_query($conexion,"UPDATE detalle_pago_servicios SET activo = '0' WHERE id_bitacora_servicio = '$id_detalle'");
	
	echo "ok";
?>