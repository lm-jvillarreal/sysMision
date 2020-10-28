<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_pieza = $_POST['id_pieza'];	
	$cadena = mysqli_query($conexion,"SELECT
											cantidad
										FROM historial_existencias 
										WHERE codigo_interno = '$id_pieza'");
    $row = mysqli_fetch_array($cadena);
    echo $row[0];
?>