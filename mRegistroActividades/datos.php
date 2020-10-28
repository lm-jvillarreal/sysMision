<?php
    include '../global_seguridad/verificar_sesion.php';
    
    $cantidad = 0;
    $json     = [];
    $i        = 1;
    $horar    = "";

    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    	$filtro = "AND fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
    	$filtro = "";
    }

    $i    = 8;
    $hora = "";
    while ($i <= 20) {
        $hora = str_pad($i, 2, "0", STR_PAD_LEFT);
    	$cadena = mysqli_query($conexion,"SELECT COUNT(*) FROM actividades_usuario WHERE activo = '1' AND id_usuario = '$id_usuario' AND hora LIKE '$hora%'".$filtro);
    	$row1 = mysqli_fetch_array($cadena);
        //if($row1[0] != 0){
            $json[] = [(string)$hora.':00',(int)$row1[0]]; 
        //}
        $i ++;
    }

    echo json_encode($json);
?>