<?php
	include '../global_seguridad/verificar_sesion.php';

	$id         = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE me_control_tiempos SET comentario_pagado = '',  tipo = '1', activo = '1' WHERE id = '$id'");
	echo "ok";
?>