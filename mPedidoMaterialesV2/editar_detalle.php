<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT id_material, (SELECT nombre FROM catalogo_materiales2 WHERE catalogo_materiales2.id = detalle_pedido.id_material ), cantidad FROM detalle_pedido WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0],$row[1],$row[2]);
	echo json_encode($array);
?>