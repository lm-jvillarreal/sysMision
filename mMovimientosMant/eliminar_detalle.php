<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE historial_ordenes SET activo = '0' WHERE id_historial = '$id'");
	echo "ok";
?>