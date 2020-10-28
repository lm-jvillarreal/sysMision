<?php
	include '../global_seguridad/verificar_sesion.php';

	$id     = $_POST['id'];
	$valor  = $_POST['valor'];
	$cadena = mysqli_query($conexion,"UPDATE vacaciones_promotor SET activo = '0', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id_promotor = '$id' AND activo = '1'");
	$cadena = mysqli_query($conexion,"UPDATE promotores SET activo = '$valor' WHERE id = '$id'");
	echo "ok";
?>