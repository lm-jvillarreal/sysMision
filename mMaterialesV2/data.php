<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_material = $_POST['id_material'];
	
	$cadena = mysqli_query($conexion,"SELECT existencia FROM catalogo_materiales2 WHERE id = '$id_material'");

	$row = mysqli_fetch_array($cadena);

	echo $row[0];
?>