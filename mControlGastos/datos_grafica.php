<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];

    $json[] = "";

    $consulta = mysqli_query($conexion,"SELECT rfc_emisor, SUM(monto)
                FROM detalle_control_gastos
                WHERE fecha_emision BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)
                GROUP BY rfc_emisor");
    while ($row = mysqli_fetch_array($consulta)) {
        $json[] = [(string)$row[0], (double)$row[1]];
    }
    // echo $gasto;
    echo json_encode($json);
?>