<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT id_sucursal,
											marca,
											modelo,
											tipo,
											capacidad,
											entrada_salida,
											tomacorrientes,
											tiempo_respaldo,
											garantia,
											series,
											ubicacion,
											no_serie
										FROM equipo_ups 
										WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    $row[7],
					$row[8],
					$row[9],
					$row[10],
					$row[11]);
	$array1 = json_encode($array);
	echo $array1;	
?>