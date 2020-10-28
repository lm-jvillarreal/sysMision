<?php
	include '../global_seguridad/verificar_sesion.php';

    $id      = $_POST['id'];
    $dato    = $_POST['dato'];
    $mensaje = "";

    if($dato == 1){
        $cadena_verificar = mysqli_query($conexion,"SELECT pedido FROM catalogo_materiales2 WHERE id = '$id'");
        $row_verificar = mysqli_fetch_array($cadena_verificar);
        if($row_verificar[0] == "1"){
            $cadena= mysqli_query($conexion,"UPDATE catalogo_materiales2 SET pedido = '2' WHERE id = '$id'");
            $mensaje = "ok";
        }else if($row_verificar[0] == "2"){
            $cadena= mysqli_query($conexion,"UPDATE catalogo_materiales2 SET pedido = '0' WHERE id = '$id'");
            $mensaje = "entregado";
        }else{
            $cadena= mysqli_query($conexion,"UPDATE catalogo_materiales2 SET pedido = '1' WHERE id = '$id'");
            $mensaje = "ok";
        }
    }else{
        $cadena= mysqli_query($conexion,"UPDATE catalogo_materiales2 SET pedido = '0' WHERE id = '$id'");
        $mensaje = "cancelado";
    }
    echo $mensaje;
	
?>