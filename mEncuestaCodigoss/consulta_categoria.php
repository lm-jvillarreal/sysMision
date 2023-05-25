<?php
	include '../global_seguridad/verificar_sesion.php';

	$cadena = mysqli_query($conexion,"SELECT MAX(id) FROM categoria_codigos");
	$row    = mysqli_fetch_array($cadena);
	echo $row[0];
?>