<?php
    include '../global_seguridad/verificar_sesion.php';
	include "../global_settings/conexion_oracle.php";

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $tipo = $_POST['tipo'];
    $sucursal = (isset($_POST['sucursal']))?$_POST['sucursal']:"";
    
    $filtro = ($sucursal != "")?"AND id_sucursal = '$sucursal'":"";
    $filtro2 = ($tipo == 1)?" AND contador = 9":"AND inv_mapeo.contador = 6";

    $cadena = mysqli_query($conexion,"SELECT COUNT(*) FROM inv_mapeo WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND activo = '0' AND completo = '1'".$filtro.$filtro2);
    $row = mysqli_fetch_array($cadena);
    
    $cadena2 = mysqli_query($conexion,"SELECT COUNT(*) FROM inv_detalle_mapeo INNER JOIN inv_mapeo ON inv_mapeo.id = inv_detalle_mapeo.id_mapeo WHERE inv_detalle_mapeo.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND inv_mapeo.activo = '0' AND inv_mapeo.completo = '1' AND inv_mapeo.asignado = 0 ".$filtro.$filtro2);
    $row2 = mysqli_fetch_array($cadena2);
    
    $array = array(number_format($row[0]),number_format($row2[0]));

    echo json_encode($array);
?>