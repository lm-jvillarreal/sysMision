<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_parte = $_POST['id_parte'];	
	$cadena = mysqli_query($conexion,"SELECT
											descripcion_det,
											costo_pza
										FROM catalogo_piezas 
										WHERE codigo_interno = '$id_parte'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],$row[1]);
	$array1 = json_encode($array);
	echo $array1;	
?>