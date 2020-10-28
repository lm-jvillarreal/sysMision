<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											id_proveedor,
											(SELECT nombre FROM proveedores_mantenimiento WHERE proveedores_mantenimiento.id_proveedor = entradas.id_proveedor),
											orden_compra,
											factura,
											fecha,
											comentarios
										FROM entradas 
										WHERE id_entrada = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
					$row[3],
					$row[4],
					$row[5]);
	$array1 = json_encode($array);
	echo $array1;	
?>