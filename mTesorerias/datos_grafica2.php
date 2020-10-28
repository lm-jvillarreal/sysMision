<?php
    include '../global_seguridad/verificar_sesion.php';

    $fecha1   = $_POST['fecha1'];
    $fecha2   = $_POST['fecha2'];
    $sucursal = $_POST['sucursal'];
    
    $json           = [];
    $nombre         = "";
    $cantidad_cajas = 0;

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
        $filtro  = " AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
        $filtro  = "";
    }
    if(!empty($_POST['sucursal'])){
        $filtro_suc = " AND id_sucursal = '$sucursal'";
    }else{
        $filtro_suc = "";
    }

    $cadena = mysqli_query($conexion,"SELECT SUM(resultado) FROM prestamos_morralla WHERE activo = '1'".$filtro.$filtro_suc);
    $row = mysqli_fetch_array($cadena);

    $json[] = [(string)"Prestamos",(double)$row[0]];

    echo json_encode($json);
?>