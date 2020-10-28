<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_parte = $_POST['id_parte'];	
	$cadena = mysqli_query($conexion,"SELECT cantidad
									  FROM historial_existencias 
									  WHERE codigo_interno = '$id_parte'");
    $row = mysqli_fetch_array($cadena);
    echo $row[0];
?>