<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT
	fecha,
	id_area,
	(SELECT nombre	FROM areas_mantenimiento WHERE areas_mantenimiento.id = actividades_mantenimiento.id_area),
	id_sucursal,
	(SELECT nombre FROM sucursales WHERE sucursales.id = actividades_mantenimiento.id_sucursal),
	id_t_actividad,
	(SELECT nombre FROM tipo_actividad_mantenimiento WHERE tipo_actividad_mantenimiento.id = actividades_mantenimiento.id_t_actividad),	
	tiempo,
	actividad
    FROM actividades_mantenimiento WHERE id = '$id'");
    $row = mysqli_fetch_array($cadena);
    $array = array($row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    $row[7],
                    $row[8]);
	$array1 = json_encode($array);
	echo $array1;	
?>