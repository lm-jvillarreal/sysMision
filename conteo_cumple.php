<?php
	include 'global_settings/conexion.php';

	$cadena_cumple = "SELECT id, CONCAT(nombre, ' ',ap_paterno), fecha_nac FROM personas WHERE DATE_FORMAT(fecha_nac, '%m%d') = DATE_FORMAT(CURDATE(),'%m%d')";
	$consulta_cumple = mysqli_query($conexion, $cadena_cumple);
	$conteo = mysqli_num_rows($consulta_cumple);
	echo $conteo;
