<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT id, nombre FROM pedido_materiales WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1]);
	echo json_encode($array);
?>