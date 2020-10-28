<?php
  	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre FROM sub_departamentos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0]);

	echo json_encode($array);
?>