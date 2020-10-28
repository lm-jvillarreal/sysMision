<?php
	include '../global_seguridad/verificar_sesion.php';

	$id    = $_POST['id'];
	$valor = $_POST['valor'];
	$resultado = 0;

	$cadena_anterior = mysqli_query($conexion,"SELECT existencia FROM catalogo_materiales2 WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena_anterior);
	$resultado = $row[0] + $valor;
	
	$cadena = mysqli_query($conexion,"UPDATE catalogo_materiales2 SET existencia = '$resultado' WHERE id = '$id'");
	$cadena3 = mysqli_query($conexion,"INSERT INTO materiales_movimientos (id_material, id_pedido, tipo, cantidad, fecha, hora, id_usuario) VALUES('$id','0','2','$valor','$fecha','$hora','$id_usuario')");

	echo "ok";
?>