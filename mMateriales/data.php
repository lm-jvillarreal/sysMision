<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_material = $_POST['id_material'];
	
	$cadena = mysqli_query($conexion,"SELECT existencia FROM historial_existencia_materiales WHERE codigo = '$id_material'");

	$row = mysqli_fetch_array($cadena);

	echo $row[0];
?>