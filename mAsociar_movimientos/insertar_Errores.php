<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
    $fechahora=date("Y-m-d H:i:s");

    $id_registro_modal = $_POST['id_registro_modalError'];
    $comentario = $_POST['comentarioError'];

    if($id_registro_modal == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM bitacora_errores_movimientos WHERE error = '$comentario'");
        $existe = mysqli_num_rows($cadena_verificar);
        if($existe == 0){
            $cadena = "INSERT INTO bitacora_errores_movimientos (error, fechahora, activo, id_usuario, comentario) VALUES ('$comentario','$fechahora','1','$id_usuario','$comentario')";
            echo $cadena;
        }else{
            echo "duplicado";
        }
    }else{
        $cadena = "UPDATE bitacora_errores_movimientos SET nombre = '$comentario', fechahora = '$fechahora' WHERE id = '$id_registro_modal'";
        echo "ok";
    }
    //$consulta = mysqli_query($conexion, $cadena);
?>
