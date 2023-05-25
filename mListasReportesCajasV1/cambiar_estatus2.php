<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE reportes_cajas SET status = '2' WHERE id = '$id'");
	echo "ok";
?>