<?php
  	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"UPDATE sub_departamentos SET activo = '0' WHERE id = '$id'");
	echo "ok";
?>