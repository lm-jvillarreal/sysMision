<?php
	include '../global_seguridad/verificar_sesion.php';

	$codigo = $_POST['codigo'];
	$cadena = mysqli_query($conexion,"UPDATE detalle_examen SET activo = '0' WHERE codigo = '$codigo'");
	echo "ok";
?>