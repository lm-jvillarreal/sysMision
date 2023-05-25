<?php
    include '../global_seguridad/verificar_sesion.php';
    include '../global_settings/conexion_oracle.php';


    $id_persona = $_POST['id_persona'];

    //$filtro =(!empty($registros_propios) == '1')?" AND id_usuario = '$id_usuario'":"";z
    $cadena = "SELECT id, (SELECT nombre FROM examenes WHERE examenes.id = examenes_asignados.id_examen) FROM examenes_asignados WHERE empleado = '$id_persona' AND activo = '1'";    

    $consulta = mysqli_query($conexion, $cadena);
    $cuerpo   = "";
    $numero   = 1;
    while ($row = mysqli_fetch_array($consulta)){
        $cadena2 = mysqli_query($conexion,"SELECT AVG(calificacion), DATE_FORMAT(fecha,'%d-%m-%Y') FROM resultados_examen WHERE id_asignado = '$row[0]'");
        $row2 = mysqli_fetch_array($cadena2);
        $promedio = ($row2[0] == "")?"N/A":round($row2[0],2);
        $fecha_a = ($row2[1] == "")?"N/A":$row2[1];
        $boton = "<a class='btn btn-warning' type='button' target='_blank' href='r_examen.php?id_asignado=$row[0]'><i class='fa fa-eye fa-lg' aria-hidden='true'></i></a>";
        $renglon = "
        {
            \"#\": \"$numero\",
            \"Examen\": \"$row[1]\",
            \"Calificacion\": \"$promedio\",
            \"Fecha\": \"$fecha_a\",
            \"Ver\": \"$boton\"
        },";
        $cuerpo = $cuerpo.$renglon;
        $numero ++;
    }

    $cuerpo2 = trim($cuerpo, ',');
    $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
    //echo $cadena_cartas;
    echo $tabla;
?>