<?php
    
    include '../global_seguridad/verificar_sesion.php';

    $fechaI = $_POST['fecha1'];
    $fechaF = $_POST['fecha2'];
    $sucursal  = $_POST['sucursal'];

    if ($sucursal == ""){
        $cadena   = "SELECT id,tipo FROM tipos_incidencias WHERE activo = '1'";
        $consulta = mysqli_query($conexion,$cadena);
        $cantidad = mysqli_num_rows($consulta);

        $gasto = 0;
        $json  = [];
        $json1  = [];
        while ($row = mysqli_fetch_array($consulta)) {
            $cadena2 = mysqli_query($conexion,"SELECT COUNT(i.id), i.sucursal, s.id  FROM incidencias i 
                                                INNER JOIN sucursales s ON i.sucursal = s.nombre 
                                                WHERE tipo = '$row[0]' AND i.fecha BETWEEN CAST('$fechaI' AS DATE) AND CAST('$fechaF' AS DATE) 
                                                and s.activo = '1'");
        //cadena a prueba SELECT COUNT(i.id), i.sucursal, s.id  FROM incidencias i INNER JOIN sucursales s ON i.sucursal = s.nombre WHERE i.fecha BETWEEN CAST('2022-07-01' AS DATE) AND CAST('2022-07-11' AS DATE) and s.activo = '1' GROUP BY i.sucursal
        //cadena original SELECT COUNT(id) FROM incidencias WHERE tipo = '$row[0]'AND fecha BETWEEN CAST('$fechaI' AS DATE)AND CAST('$fechaF' AS DATE)    
        $row1 = mysqli_fetch_array($cadena2);
           
           // $gasto = $row1[0];
            if($row1[0] == ""){
                $gasto = 0;
            }
            else{
                $gasto = $row1[0];
            }
            $json[] = [(string)$row[1], (int)$gasto];
            $gasto = 0; 
           
        }
    }else{
        if($sucursal == '1'){
            $Suc = "DIAZ ORDAZ";
        }else if($sucursal == '2'){
            $Suc = "ARBOLEDAS";
        }else if($sucursal == '3'){
            $Suc = "VILLEGAS";
        }else if($sucursal == '4'){
            $Suc = "ALLENDE";
        }else if($sucursal == '5'){
            $Suc = "PETACA";
        }else if($sucursal == '99'){
            $Suc = "CEDIS";
        }
        $cadena   = "SELECT id,tipo FROM tipos_incidencias WHERE activo = '1'";
        $consulta = mysqli_query($conexion,$cadena);
        $cantidad = mysqli_num_rows($consulta);

        $gasto = 0;
        $json  = [];
        $json1  = [];
        while ($row = mysqli_fetch_array($consulta)) {
            $cadena2 = mysqli_query($conexion,"SELECT COUNT(id) FROM incidencias WHERE tipo = '$row[0]' AND sucursal = '$Suc' 
                                    AND fecha BETWEEN CAST('$fechaI' AS DATE)
                                    AND CAST('$fechaF' AS DATE)");
                                    
            $row1 = mysqli_fetch_array($cadena2);
           
           // $gasto = $row1[0];
            if($row1[0] == ""){
                $gasto = 0;
            }
            else{
                $gasto = $row1[0];
            }
            $json[] = [(string)$row[1], (int)$gasto];
            $gasto = 0; 
           
        }
    }

    echo json_encode($json);
?>