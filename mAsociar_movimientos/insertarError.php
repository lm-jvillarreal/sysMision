<?php
	include '../global_seguridad/verificar_sesion.php';
	//Fecha y hora actual
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");
    $fechahora=date("Y-m-d H:i:s");

    $id_registroError = $_POST['id_registroError'];
    $MovimientoError = $_POST['MovimientoError'];
    $comentarioError = $_POST['comentarioError'];
    $SucursalError = $_POST['SucursalError'];
    $EmpleadoError = $_POST['EmpleadoError'];
    $error = $_POST['error'];

        if($id_registro_modalError == 0){
        $cadena_verificar = mysqli_query($conexion,"SELECT id FROM bitacora_errores_movimientos WHERE nombre = '$comentario'");
        $existe = mysqli_num_rows($cadena_verificar);
        if($existe == 0){
            $cadena = "INSERT INTO bitacora_errores_movimientos (movimiento, id_movimiento, sucursal,imprime, error, comentario, fechahora, activo, usuario) VALUES ('$MovimientoError','$id_registroError','$SucursalError','$EmpleadoError','$error','$comentarioError','$fechahora','1','$id_usuario')";
            echo "ok";
        }else{
            echo "duplicado";
        }
    }else{
        $cadena = "UPDATE bitacora_errores_movimientos SET nombre = '$comentarioError', fechahora = '$fechahora' WHERE id = '$id_registro_Error'";
        echo "ok";
    }
    $consulta = mysqli_query($conexion, $cadena);
?>
