<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];

	$cadena = mysqli_query($conexion,"DELETE FROM agenda WHERE folio = '$folio'");
	echo "ok";
?>