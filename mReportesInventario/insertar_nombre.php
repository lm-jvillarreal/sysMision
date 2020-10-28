<?php
    include "../global_settings/conexion.php";
    //include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set("America/Monterrey");
    //$fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];
    $sucursal = $_POST['sucursal'];

    $sql = "INSERT INTO fechas_mapeo(fecha, fecha_registro, nombre, sucursal) VALUES('$fecha', CURRENT_DATE, '$nombre', '$sucursal')";
    $exSql = mysqli_query($conexion, $sql);
    echo "$sql";
    
 ?>
