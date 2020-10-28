<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $cadena = "SELECT id,nombre FROM rublos WHERE activo = '1'";
    $consulta = mysqli_query($conexion,$cadena);
    $cantidad = mysqli_num_rows($consulta);

    $gasto = 0;
    $json  = [];

    while ($row = mysqli_fetch_array($consulta)) {
        $cadena2 = mysqli_query($conexion,"SELECT SUM(gasto) FROM gastos_sistemas WHERE id_rublo = '$row[0]'");
        $row1 = mysqli_fetch_array($cadena2);
        
        if($row1[0] == ""){
            $gasto = 0.00;
        }
        else{
            $gasto = $row1[0];
        }
        $json[] = [(string)$row[1], (int)$gasto];
        $gasto = 0;
    }
    // echo $gasto;
    echo json_encode($json);
?>