<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_promotor = $_POST['id_promotor'];

	$cadena = mysqli_query($conexion,"DELETE FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");

	echo 'ok';
?>
