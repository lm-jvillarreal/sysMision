<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];

	$cadena = mysqli_query($conexion,"UPDATE actividades_usuario SET estatus = '1', fecha_realizacion = '$fecha', hora_realizacion = '$hora' WHERE folio = '$folio' AND principal = '0'");

	echo "ok";
?>