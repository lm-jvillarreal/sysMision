<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											id_proveedor,
											(SELECT nombre FROM proveedores_mantenimiento WHERE proveedores_mantenimiento.id_proveedor = ordenes_compra_mantenimiento.id_proveedor),
											vendedor,
											telefono,
											folio
										FROM ordenes_compra_mantenimiento 
										WHERE id_orden_entrada = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
					$row[3],
					$row[4]);
	$array1 = json_encode($array);
	echo $array1;	
?>