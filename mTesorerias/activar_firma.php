<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$consulta = mysqli_query($conexion,"UPDATE firmas SET activo = '1' WHERE id = '$id'");
	$cadena   = mysqli_query($conexion,"SELECT id from firmas WHERE id != '$id'");
	while($row = mysqli_fetch_array($cadena)){
		$consulta = mysqli_query($conexion,"UPDATE firmas SET activo = '0' WHERE id = '$row[0]'");
	}
	echo "ok";
?>