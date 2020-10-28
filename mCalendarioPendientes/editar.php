<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT pendiente, fecha_inicial, fecha_final, id_tipo_actividad, (SELECT nombre FROM  tipo_actividad_mantenimiento WHERE tipo_actividad_mantenimiento.id = pendientes_mantenimiento.id_tipo_actividad), id_usuario_asignado, (SELECT CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = pendientes_mantenimiento.id_usuario_asignado)
    FROM pendientes_mantenimiento WHERE id = '$id'");
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