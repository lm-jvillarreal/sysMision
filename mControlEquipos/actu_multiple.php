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
        $cadena2 = mysqli_query($conexion,"SELECT equipo, descripcion FROM detalle_caja WHERE id_caja = '$caja_base' AND activo = '1'");
        while($row2 = mysqli_fetch_array($cadena2)){
            $cadena3 = mysqli_query($conexion,"UPDATE detalle_caja SET equipo = '$row2[0]', descripcion = '$row2[1]', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$caja'");  
        }
    }

    $cadena = mysqli_query($conexion,"SELECT id FROM cajas WHERE activo = '1' AND id != '$caja_base'".$filtro);
    while($row = mysqli_fetch_array($cadena)){
        insertar_datos($caja_base,$row[0],$conexion,$id_usuario,$fecha,$hora);        
    }
    echo "ok";
?>