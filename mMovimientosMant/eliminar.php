<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE eliminar SET activo = '0' WHERE id_entrada = '$id'");
	echo "ok";
?>