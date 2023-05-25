<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT reportes_cajas.id_caja,
                                            CONCAT(cajas.nombre,' ',sucursales.nombre),
                                            reportes_cajas.id_equipo,
                                            CONCAT(cajas_catalogo_equipos.nombre, ' - ', cajas_catalogo_equipos.descripcion),
                                            id_falla,
                                            fallas_equipos.nombre,
                                            reportes_cajas.tipo
                                        FROM reportes_cajas
                                        INNER JOIN cajas ON cajas.id = reportes_cajas.id_caja
                                        INNER JOIN detalle_caja ON detalle_caja.id = reportes_cajas.id_equipo
                                        INNER JOIN sucursales ON sucursales.id = cajas.id_sucursal
                                        INNER JOIN cajas_catalogo_equipos ON cajas_catalogo_equipos.id = reportes_cajas.id_equipo
                                        LEFT JOIN fallas_equipos ON fallas_equipos.id = reportes_cajas.id_falla
                                        WHERE reportes_cajas.id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $nombref = ($row[5] == "")?"":$row[5];
	$array = array($row[0],$row[1],$row[2],$row[3],$row[4],$nombref,$row[6]);
	$array1 = json_encode($array);
	echo $array1;	
?>