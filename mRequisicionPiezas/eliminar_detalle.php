<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE detalle_historial_requisicion SET activo = '0' WHERE id = '$id'");
	
	$cadena2 = mysqli_query($conexion,"SELECT id_historial, codigo, cantidad FROM detalle_historial_requisicion WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena2);
	
	$cadena2 = mysqli_query($conexion,"SELECT id_sucursal FROM historial_requisicion WHERE id = '$row[0]'");
	$row2 = mysqli_fetch_array($cadena2);

	$consulta3="UPDATE historial_existencias
                SET cantidad = cantidad + '$row[2]'
                WHERE codigo_interno = '$row[1]' 
				AND id_almacen = '$row2[0]'";
	$result = mysqli_query($conexion, $consulta3);

	echo "ok";
?>