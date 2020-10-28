<?php
	include '../global_seguridad/verificar_sesion.php';

	$cajas = $_POST['cajas'];
	$id    = $_POST['id'];

	$cadena = mysqli_query($conexion,"UPDATE registro_actividades SET cajas_surtidas = '$cajas' WHERE id = '$id'");
	echo "ok";
?>