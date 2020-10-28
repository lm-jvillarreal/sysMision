<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_proveedor = $_POST['id_proveedor'];	
	$cadena = mysqli_query($conexion,"SELECT
											nombre_vededor,
											cel_vendedor
										FROM proveedores_mantenimiento 
										WHERE id_proveedor = '$id_proveedor'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],$row[1]);
	$array1 = json_encode($array);
	echo $array1;	
?>