<?php
	include '../global_settings/conexion.php';
	
	$id_sucursal = $_POST['sucursal'];
	
	$cadena_sucursal = mysqli_query($conexion,"SELECT id_sucursal FROM cajas WHERE id = '$id_sucursal'");
	$row_sucursal = mysqli_fetch_array($cadena_sucursal);

	$cadena   = "SELECT usuario_terminal,contrasena_terminal,afiliacion FROM sucursales WHERE id = '$row_sucursal[0]'";
	$consulta = mysqli_query($conexion, $cadena);
	
	$row = mysqli_fetch_row($consulta);

	$array  = array($row[0],$row[1],$row[2]);
	$array1 = json_encode($array);

  	echo $array1;
?>