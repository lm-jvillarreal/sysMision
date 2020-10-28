<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

    $id = $_POST['id'];
    $dato = $_POST['dato'];
    $mensaje = "";

    if($dato == 1){
        $cadena_verificar = mysqli_query($conexion,"SELECT pedido FROM catalago_materiales WHERE id = '$id'");
        $row_verificar = mysqli_fetch_array($cadena_verificar);
        if($row_verificar[0] == "1"){
            $cadena= mysqli_query($conexion,"UPDATE catalago_materiales SET pedido = '2' WHERE id = '$id'");
            $mensaje = "ok";
        }else if($row_verificar[0] == "2"){
            $cadena= mysqli_query($conexion,"UPDATE catalago_materiales SET pedido = '0' WHERE id = '$id'");
            $mensaje = "entregado";
        }else{
            $cadena= mysqli_query($conexion,"UPDATE catalago_materiales SET pedido = '1' WHERE id = '$id'");
            $mensaje = "ok";
        }
    }else{
        $cadena= mysqli_query($conexion,"UPDATE catalago_materiales SET pedido = '0' WHERE id = '$id'");
        $mensaje = "cancelado";
    }
    echo $mensaje;
	
?>