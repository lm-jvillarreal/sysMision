<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
											id_sucursal,
											(SELECT nombre FROM sucursales WHERE sucursales.id = historial_requisicion.id_sucursal),
											justificacion,
											area,
											orden_trabajo
										FROM historial_requisicion 
										WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
					$row[3],
					$row[4]);
	$array1 = json_encode($array);
	echo $array1;	
?>