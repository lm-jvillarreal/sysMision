<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE manuales SET activo = '0' WHERE id = '$id'");
	echo "ok";
?>