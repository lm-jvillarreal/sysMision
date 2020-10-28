<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_modulo = $_POST['id_modulo'];

	$cadena = mysqli_query($conexion,"SELECT ayuda_modulo,ruta_manual FROM modulos WHERE id = '$id_modulo'");
	$row    = mysqli_fetch_array($cadena);
	$array  = array($row[0],$row[1]);
	$array1 = json_encode($array);
	echo $array1;
?>