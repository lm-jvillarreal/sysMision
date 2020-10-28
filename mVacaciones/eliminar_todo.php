<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_usuarioE = $_POST['id_usuario'];
	$cadena = mysqli_query($conexion,"UPDATE historico_vacaciones SET activo = '0' WHERE id_usuario = '$id_usuarioE'");
	echo "ok";
?>