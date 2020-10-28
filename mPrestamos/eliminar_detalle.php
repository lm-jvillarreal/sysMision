<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE historial_prestamos SET activo = '0' WHERE id = '$id'");

	$cadena2 = mysqli_query($conexion,"SELECT codigo_interno, cantidad FROM historial_prestamos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena2);


	$consulta3="UPDATE historial_existencias
                SET cantidad = cantidad + '$row[1]'
                WHERE codigo_interno = '$row[0]' 
                AND id_almacen = '2'";             
	$result = mysqli_query($conexion, $consulta3);
	
	echo "ok";
?>