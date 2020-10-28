<?php
    include '../global_seguridad/verificar_sesion.php';
    $cantidad    = 0;
    $json        = [];
    $i           = 1;

    $fecha1      = $_POST['fecha1'];
    $fecha2      = $_POST['fecha2'];
    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    	$filtro = "AND solicitud_etiquetas.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
    	$filtro = "";
    }

    $cadena_principal = mysqli_query($conexion,"SELECT id,nombre FROM sucursales WHERE (id != '11' AND id !='12') ORDER BY id");

    while ($row_sucursales = mysqli_fetch_array($cadena_principal)) {
    	$cadena_porsucursal = mysqli_query($conexion,"
        SELECT COUNT( solicitud_etiquetas.id ) 
        FROM solicitud_etiquetas 
        INNER JOIN usuarios ON usuarios.id = solicitud_etiquetas.usuario_solicita
        INNER JOIN personas ON personas.id = usuarios.id_persona
        INNER JOIN perfil ON perfil.id = usuarios.id_perfil
        WHERE sucursal = '$row_sucursales[0]' AND estatus = '2' AND perfil.id != '4' ".$filtro);
    	$row_ps = mysqli_fetch_array($cadena_porsucursal);
    	$json[] = [(string)$row_sucursales[1], (int)$row_ps[0]]; 
        $cantidad = 0;
    }
    //echo json_encode($json);
    
?>