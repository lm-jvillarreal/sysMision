<?php
	include '../global_seguridad/verificar_sesion.php';

	$id             = $_POST['id'];
	$fecha          = $_POST['fecha'];
	$fecha_completa = $fecha.' 12:00:00';

	$cadena = mysqli_query($conexion,"SELECT start,folio FROM agenda WHERE id = '$id'");
	$row_cadena = mysqli_fetch_array($cadena);

	if($fecha_completa <= $row_cadena[0]){
		echo "menor";
	}
	else{
		$cadena = mysqli_query($conexion,"UPDATE agenda SET end = '$fecha_completa' WHERE folio = '$row_cadena[1]'");
		echo "ok";
	}?>