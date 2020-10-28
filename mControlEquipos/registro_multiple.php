<?php
    include '../global_seguridad/verificar_sesion.php';

    $caja_base  = (isset($_POST['caja_modal']))?$_POST['caja_modal']:"";
    $tipo_modal = $_POST['tipo_modal'];
    $sucursal_modal = (isset($_POST['sucursal_modal']))?$_POST['sucursal_modal']:"";

    if($caja_base == ""){
        echo "vacio";
        return false;
    }
    if($tipo_modal == 2){
        if($sucursal_modal == ""){
            echo "vacio";
            return false;
        }
    }

    $filtro = ($tipo_modal == 1)?"":" AND id_sucursal = '$sucursal_modal'";

    function insertar_datos($caja_base, $caja, $conexion, $id_usuario, $fecha, $hora){
        $cadena2 = mysqli_query($conexion,"SELECT id_equipo FROM detalle_caja WHERE id_caja = '$caja_base' AND activo = '1'");
        while($row2 = mysqli_fetch_array($cadena2)){
            $cadena_verificar = mysqli_query($conexion,"SELECT id FROM detalle_caja WHERE id_equipo = '$row2[0]'  AND id_caja = '$caja'");
            $existe = mysqli_num_rows($cadena_verificar);
            if($existe == 0){
                $cadena3 = mysqli_query($conexion,"INSERT INTO detalle_caja (id_caja, id_equipo, tipo, activo, fecha, hora, id_usuario) VALUES ('$caja','$row2[0]','1','1','$fecha','$hora','$id_usuario')");  
            }
            continue;
        }
        $existe = 0;
    }

    $cadena = mysqli_query($conexion,"SELECT id FROM cajas WHERE activo = '1' AND id != '$caja_base'".$filtro);
    while($row = mysqli_fetch_array($cadena)){
        insertar_datos($caja_base,$row[0],$conexion,$id_usuario,$fecha,$hora);        
    }
    echo "ok";
?>