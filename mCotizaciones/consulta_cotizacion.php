<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre, fecha_cotizacion, id_sucursal, (SELECT nombre FROM sucursales WHERE sucursales.id = cotizaciones.id_sucursal) FROM cotizaciones");
	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2],$row[3]);
	echo json_encode($array);
?>