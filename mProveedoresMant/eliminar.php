<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE proveedores_mantenimiento SET activo = '0' WHERE id_proveedor = '$id'");
	echo "ok";
?>