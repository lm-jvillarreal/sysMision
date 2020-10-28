<?php
	include '../global_seguridad/verificar_sesion.php';

  	$id = $_POST['id'];
  	$cadena = mysqli_query($conexion,"DELETE FROM registro_actividades WHERE id = '$id'");

  	echo "ok";
?>
