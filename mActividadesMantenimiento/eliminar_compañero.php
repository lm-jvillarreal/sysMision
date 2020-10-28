<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$cadena = mysqli_query($conexion,"UPDATE detalle_act_mant_compañeros SET activo = '0' WHERE id = '$id'");
	echo "ok";
?>