<?php
    include '../global_seguridad/verificar_sesion.php';

    $cadena = mysqli_query($conexion,"SELECT (SELECT CONCAT(nombre, ' ',ap_paterno, ' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = actividades_mantenimiento.id_usuario), COUNT(*) 
    FROM actividades_mantenimiento 
    GROUP BY id_usuario");
    while($row = mysqli_fetch_array($cadena)){
        $json[] = [(string)$row[0],(double)$row[1]];
    }

    echo json_encode($json);
?>