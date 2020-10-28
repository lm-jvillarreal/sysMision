<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT SUM(gasto) FROM gastos_sistemas WHERE activo = '1'";
    $consulta = mysqli_query($conexion,$cadena);
    $row = mysqli_fetch_array($consulta);

    $gasto = 0;
    // $json  = [];
    // echo $gasto;
    $json[] = ['Departamento Sistemas', (int)$row[0]];
    echo json_encode($json);
?>