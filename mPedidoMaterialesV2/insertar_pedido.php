<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre = $_POST['nombre'];

	$cadena = mysqli_query($conexion,"INSERT INTO pedido_materiales (nombre, estatus, fecha, hora, activo, id_usuario) VALUES ('$nombre','0','$fecha','$hora','0','$id_usuario')");
	$cadena = mysqli_query($conexion,"SELECT MAX(id) FROM pedido_materiales");
	$row = mysqli_fetch_array($cadena);

	$array = array("ok",$row[0]);	
	echo json_encode($array);
?>