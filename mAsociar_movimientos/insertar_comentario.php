<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
    $fechahora=date("Y-m-d H:i:s");

    $id_registro_modal = $_POST['id_registro_modal'];
    $comentario = $_POST['comentario'];

    if($id_registro_modal == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM comentarios_errores WHERE nombre = '$comentario'");
        $existe = mysqli_num_rows($cadena_verificar);
        if($existe == 0){
            $cadena = "INSERT INTO errores_movimientos (nombre, fechahora, activo, id_usuario) VALUES ('$comentario','$fechahora','1','$id_usuario')";
            echo "ok";
        }else{
            echo "duplicado";
        }
    }else{
        $cadena = "UPDATE errores_movimientos SET nombre = '$comentario', fechahora = '$fechahora' WHERE id = '$id_registro_modal'";
        echo "ok";
    }
    $consulta = mysqli_query($conexion, $cadena);
?>
