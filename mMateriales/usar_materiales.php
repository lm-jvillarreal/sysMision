<?php
    include '../global_seguridad/verificar_sesion.php';
    date_default_timezone_set('America/Monterrey');
    $fecha       =date("Y-m-d"); 
    $hora        =date ("h:i:s");

    $material            = $_POST['material'];
    $cantidad_existencia = $_POST['cantidad_existencia'];
    $cantidad_usado      = $_POST['cantidad'];

    if($material != "" && $cantidad_existencia != "" && $cantidad_usado != ""){
        if ($cantidad_usado != "0"){
            $resultado           = $cantidad_existencia - $cantidad_usado;
    
            $cadena = mysqli_query($conexion,"UPDATE historial_existencia_materiales SET existencia = '$resultado' WHERE id = '$material'");
            echo "ok";
        }
        else{
            echo "1";
        }
    }else{
        echo "2";
    }
?>