<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	
    $cadena = mysqli_query($conexion,"UPDATE pedido_materiales SET estatus = '3' WHERE id = '$id'");
    
    $cadena = mysqli_query($conexion,"SELECT id_material, cantidad FROM detalle_pedido WHERE id_pedido = '$id'");

    while ($row = mysqli_fetch_array($cadena)) {
    	$cadena2 = mysqli_query($conexion,"UPDATE catalogo_materiales2 SET existencia = existencia - '$row[1]' WHERE id = '$row[0]'");
    	$cadena3 = mysqli_query($conexion,"INSERT INTO materiales_movimientos (id_material, id_pedido, tipo, cantidad, fecha, hora, id_usuario) VALUES('$row[0]','$id','1','$row[1]','$fecha','$hora','$id_usuario')");
    }
    echo "ok";
?>