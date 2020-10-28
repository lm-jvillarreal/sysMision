<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_pedido = $_POST['id_pedido'];

	$cadena = mysqli_query($conexion,"UPDATE pedido_materiales SET activo = '1', estatus = '1' WHERE id = '$id_pedido'");
	echo "ok";
?>