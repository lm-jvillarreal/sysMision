<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
                                        id_sucursal,
                                        (SELECT nombre FROM sucursales WHERE sucursales.id = cajas_mantenimiento_equipos.id_sucursal),
                                        id_caja,
                                        (SELECT nombre FROM cajas WHERE cajas.id = cajas_mantenimiento_equipos.id_caja),
                                        id_equipo,
                                        (SELECT nombre FROM cajas_catalogo_equipos WHERE cajas_catalogo_equipos.id = cajas_mantenimiento_equipos.id_equipo),
                                        comentario
                                    FROM cajas_mantenimiento_equipos
                                    WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6]);
	$array1 = json_encode($array);
	echo $array1;	
?>