<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE ordenes_compra_mantenimiento SET activo = '0' WHERE id_orden_entrada = '$id'");
	echo "ok";
?>