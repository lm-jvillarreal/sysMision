<?php
	include '../global_seguridad/verificar_sesion.php';
	$id         = $_POST['id'];
	$comentario = $_POST['comentario'];
	
    $cadena = mysqli_query($conexion,"UPDATE pedido_materiales SET estatus = '0', comentarios = '$comentario' WHERE id = '$id'");
    echo "ok";
?>