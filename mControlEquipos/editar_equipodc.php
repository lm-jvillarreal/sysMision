<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_marca = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT sucursales.id, sucursales.nombre, detalle_caja.id_caja, cajas.nombre, detalle_caja.id_equipo, CONCAT(cajas_catalogo_equipos.nombre, ' - ', cajas_catalogo_equipos.descripcion)
                                        FROM detalle_caja
                                        INNER JOIN cajas ON cajas.id = detalle_caja.id_caja
                                        INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
										INNER JOIN cajas_catalogo_equipos ON cajas_catalogo_equipos.id = detalle_caja.id_equipo
                                        WHERE detalle_caja.id = '$id_marca'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
	$array1 = json_encode($array);
	echo $array1;	
?>