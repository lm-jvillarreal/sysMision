<?php
	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$comentario = $_POST['comentario'];

	$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET comentario_pagado = '$comentario',  tipo = '3', activo = '2' WHERE id = '$id'");
	echo "ok";
?>