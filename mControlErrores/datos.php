<?php
    include '../global_seguridad/verificar_sesion.php';
    $cantidad    = 0;
    $json        = [];
    $i           = 1;

    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    	$filtro = "AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
    	$filtro = "";
    }

    $cadena_principal = mysqli_query($conexion,"SELECT id,nombre FROM comentarios_errores WHERE activo = '1'");

    while ($row = mysqli_fetch_array($cadena_principal)) {
    	$cadena = mysqli_query($conexion,"SELECT COUNT(*) FROM me_control_errores WHERE activo = '1' AND comentarios = '$row[0]'".$filtro);
    	$row1 = mysqli_fetch_array($cadena);
    	$json[] = [(string)$row[1], (int)$row1[0]]; 
        $cantidad = 0;
    }
    echo json_encode($json);
?>