<?php
	include '../global_seguridad/verificar_sesion.php';

	$id    = $_POST['id'];
	$abono = $_POST['abono'];

	$cadena = mysqli_query($conexion,"UPDATE abonos SET abono = '$abono' WHERE id = '$id'");
	echo "ok";
?>