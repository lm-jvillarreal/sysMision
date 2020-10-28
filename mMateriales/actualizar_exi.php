<?php
	include '../global_seguridad/verificar_sesion.php';

	$id    = $_POST['id'];
	$valor = $_POST['valor'];
	$resultado = 0;

	$cadena_anterior = mysqli_query($conexion,"SELECT existencia FROM historial_existencia_materiales WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_anterior);
	$resultado = $row[0] + $valor;
	
	$cadena = mysqli_query($conexion,"UPDATE historial_existencia_materiales SET existencia = '$resultado' WHERE id = '$id'");
	echo "ok";
?>