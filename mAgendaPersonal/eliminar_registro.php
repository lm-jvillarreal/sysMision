<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$cadena = mysqli_query($conexion,"UPDATE historico_vacaciones SET activo = '0' WHERE folio = '$folio'");
	echo "ok";
?>