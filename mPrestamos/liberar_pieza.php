<?php
	include '../global_seguridad/verificar_sesion.php';
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
	$cadena = mysqli_query($conexion,"UPDATE historial_prestamos SET activo = '2', cantidad_entregada = '$cantidad' WHERE id = '$id'");
	$cadena2 = mysqli_query($conexion,"SELECT codigo_interno FROM historial_prestamos WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena2);


	$consulta3="UPDATE historial_existencias
                SET cantidad = cantidad + '$cantidad'
                WHERE codigo_interno = '$row[0]' 
                AND id_almacen = '2'";             
    $result = mysqli_query($conexion, $consulta3); 
	echo "ok";
?>