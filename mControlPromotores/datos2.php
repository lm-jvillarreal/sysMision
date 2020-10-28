<?php
    include '../global_seguridad/verificar_sesion.php';

    $fecha1   = $_POST['fecha1'];
    $fecha2   = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    
    $json           = [];
    $nombre         = "";
    $cantidad_cajas = 0;

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    	$filtro = "AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
    	$filtro = "";
    }

    if(!empty($_POST['sucursal'])){
        $filtro2 = " AND id_sucursal = '$sucursal'";
    }else{
        $filtro2 = "";
    }

    $cadena = mysqli_query($conexion,"SELECT id,CONCAT(nombre,' ',ap_paterno,' - ',compañia) FROM promotores WHERE activo = '1'");
    while ($row = mysqli_fetch_array($cadena)) {
        $nombre = $row[1];
        $cadena_actividades = mysqli_query($conexion,"SELECT SUM(cajas_surtidas) FROM actividades_promotor  LEFT JOIN registro_actividades ON registro_actividades.id_actividad = actividades_promotor.id WHERE id_promotor = '$row[0]'".$filtro.$filtro2);
        $row_act = mysqli_fetch_array($cadena_actividades);
        $cantidad_cajas = $row_act[0];

        if($cantidad_cajas != 0){
            $json[] = [(string)$nombre,(int)$cantidad_cajas]; 
        }   
        $nombre         = "";
        $cantidad_cajas = 0;
    }

    echo json_encode($json);
?>