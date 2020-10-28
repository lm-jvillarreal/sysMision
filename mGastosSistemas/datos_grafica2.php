<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $fechaI = $_POST['fecha1'];
    $fechaF = $_POST['fecha2'];
    $rublo  = $_POST['rublo'];

    if ($rublo == ""){
        $cadena   = "SELECT id,nombre FROM rublos WHERE activo = '1'";
        $consulta = mysqli_query($conexion,$cadena);
        $cantidad = mysqli_num_rows($consulta);

        $gasto = 0;
        $json  = [];
        $json1  = [];
        while ($row = mysqli_fetch_array($consulta)) {
            $cadena2 = mysqli_query($conexion,"SELECT SUM(gasto) FROM gastos_sistemas WHERE id_rublo = '$row[0]'
                                    AND fecha_movimiento BETWEEN CAST('$fechaI' AS DATE)
                                    AND CAST('$fechaF' AS DATE)");
                                    // echo $cadena2;
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
    }else{
        $cadena = "SELECT gasto,proveedor FROM gastos_sistemas WHERE id_rublo = '$rublo' AND fecha_movimiento BETWEEN CAST('$fechaI' AS DATE)
        AND CAST('$fechaF' AS DATE)";
        $consulta = mysqli_query($conexion,$cadena);
        $cantidad = mysqli_num_rows($consulta);

        $gasto = 0;
        $json  = [];
        $json1  = [];
        $cadena_fin = "";

        while ($row = mysqli_fetch_array($consulta)) {
            $cadena_fin = mysqli_query($conexion,"SELECT SUM(gasto) FROM gastos_sistemas WHERE proveedor = '$row[1]' AND id_rublo = '$rublo' AND fecha_movimiento BETWEEN CAST('$fechaI' AS DATE)
        AND CAST('$fechaF' AS DATE)");
            $row2 = mysqli_fetch_array($cadena_fin);
            $gasto = $row2[0];

            $json[] = [(string)$row[1], (int)$gasto];
            $gasto = 0;
        }
    }
    echo json_encode($json);
?>