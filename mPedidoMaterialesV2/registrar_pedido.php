<?php
	include '../global_seguridad/verificar_sesion.php';

	$material   = $_POST['material'];
	$cantidad   = $_POST['cantidad'];
	$id_pedido  = $_POST['id_pedido'];
	$id_detalle = $_POST['id_detalle'];

	if($id_detalle == 0){
		$cadena = "INSERT INTO detalle_pedido (id_pedido, id_material, cantidad, fecha, hora, activo, id_usuario) VALUES ('$id_pedido','$material','$cantidad','$fecha','$hora','1','$id_usuario')";
	}else{
		$cadena = "UPDATE detalle_pedido SET cantidad = '$cantidad' WHERE id = '$id_detalle'";
	}
	$consulta = mysqli_query($conexion,$cadena);
	echo "ok";	
?>