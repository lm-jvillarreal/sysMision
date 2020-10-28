<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

    $rublo_modal       = $_POST['rublo_modal'];
    $id_registro_modal = $_POST['id_registro_modal'];

    if($id_registro_modal == 0){
        $verificar = mysqli_query($conexion,"SELECT id FROM rublos WHERE nombre = '$rublo_modal' AND activo = '1' AND tipo = '1'");
        $cantidad  = mysqli_num_rows($verificar);
        
        if ($cantidad == 0){
            $cadena = "INSERT INTO rublos (nombre,fecha,hora,activo,id_usuario,tipo)
                    VALUES ('$rublo_modal','$fecha','$hora','1','$id_usuario','1')";
            $consulta = mysqli_query($conexion,$cadena);
            echo "ok";
        }
        else{
            echo "duplicado";
        }
    }
    else{
        $cadena = mysqli_query($conexion,"UPDATE rublos SET nombre = '$rublo_modal' WHERE id = '$id_registro_modal'");
        echo "ok";
    }


?>
