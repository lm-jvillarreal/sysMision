<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											id_sucursal,
											(SELECT nombre FROM sucursales WHERE sucursales.id = prestamos.id_sucursal),
											persona,
											fecha_entrega
										FROM prestamos 
										WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
					$row[3]);
	$array1 = json_encode($array);
	echo $array1;	
?>