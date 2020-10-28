<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT comentarios FROM pedido_materiales WHERE id = '$id'");

	$row = mysqli_fetch_array($cadena);

	echo $row[0];
?>