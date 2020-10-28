<?php
	include '../global_seguridad/verificar_sesion.php';

	$id     = $_POST['id'];
	$nombre = $_POST['nombre'];

	$cadena = mysqli_query($conexion,"SELECT nombre FROM agrupaciones WHERE id = '$id'");
	$row_cadena = mysqli_fetch_array($cadena);

	if($nombre == $row_cadena[0]){
		echo "igual";
	}
	else{
		$cadena = mysqli_query($conexion,"UPDATE agrupaciones SET nombre = '$nombre' WHERE id = '$id'");
		echo "ok";
	}
?>