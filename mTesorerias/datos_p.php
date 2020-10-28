<?php
	include '../global_seguridad/verificar_sesion.php';
	$folio = $_POST['folio'];

	$cadena     = mysqli_query($conexion,"SELECT concepto, cantidad,id FROM otros WHERE id = '$id'");
	$row_cadena = mysqli_fetch_array($cadena);
	$cantidad   = mysqli_num_rows($cadena);

	$array_datos = array($row_cadena[0],$row_cadena[1],$row_cadena[2],$cantidad);

	$array = json_encode($array_datos);
	echo $array;
?>