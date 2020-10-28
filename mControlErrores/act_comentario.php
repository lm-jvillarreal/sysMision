<?php
	include '../global_seguridad/verificar_sesion.php';
	$id    = $_POST['id'];
	$valor = $_POST['valor'];

	$cadena = mysqli_query($conexion,"UPDATE me_control_errores SET comentarios = '$valor' WHERE id ='$id'");
	echo 'ok';
?>