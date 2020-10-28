<?php
    include '../global_seguridad/verificar_sesion.php';

    $fecha1         = $_POST['fecha1'];
    $fecha2         = $_POST['fecha2'];
    
    $json           = [];
    $nombre_sucursal         = "";
    $cantidad_cajas = 0;

    if(!empty($_POST['fecha1']) && !empty($_POST['fecha2'])){
    	$filtro = "AND registro_actividades.fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
    }else{
    	$filtro = "";
    }

    $cadena_sucursales = mysqli_query($conexion,"SELECT id,nombre FROM sucursales WHERE activo = '1' ORDER BY id");
    $cadena = "";
    while ($row_sucursales = mysqli_fetch_array($cadena_sucursales)) {
        $nombre_sucursal = $row_sucursales[1];
        $cadena_visitas = mysqli_query($conexion,"SELECT COUNT(*),promotores.nombre
                            FROM agenda_promotores 
                            INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
                            WHERE agenda_promotores.activo = '1' AND agenda_promotores.id_sucursal = '$row_sucursales[0]'
                            GROUP BY id_promotor");
       
        // $cadena = "[{ \"name:\" $nombre_sucursal,
        //             \"data:\"[{
        //                 \"name:\"$row_visitas[1],
        //                 \"value:\"$row_visitas[0]
        //             }}]
        //            }]";
    //                $cadena = "[{
    //     name: 'Oceania',
    //     data: [{
    //         name: \"Australia\",
    //         value: 409.4
    //     },
    //     {
    //         name: \"New Zealand\",
    //         value: 34.1
    //     },
    //     {
    //         name: \"Papua New Guinea\",
    //         value: 7.1
    //     }]
    // }]";
        while ($row_visitas = mysqli_fetch_array($cadena_visitas)) {
            $cadena .= "";
            $json[] = [(string)$row_visitas[1],(int)$row_visitas[0]]; 
        }

    }

    echo json_encode($json);
    // echo $cadena;
?>