<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_caja = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT nombre, id_sucursal, (SELECT nombre FROM sucursales WHERE sucursales.id = cajas.id_sucursal), id_tipo_caja FROM cajas WHERE id = '$id_caja'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2],$row[3]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>