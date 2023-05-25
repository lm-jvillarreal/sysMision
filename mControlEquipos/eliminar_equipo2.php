<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];
	$cadena ="UPDATE tipos_equipos SET activo = '0' WHERE id_tipo = '$id'";
	$update= mysqli_query($conexion,$cadena);
	echo "ok";
?>