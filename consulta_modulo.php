<?php
	include 'global_settings/conexion.php';

  	$modulo = $_POST['modulo'];

  	$cadena = mysqli_query($conexion,"SELECT nombre_carpeta FROM modulos WHERE id = '$modulo'");
  	$row = mysqli_fetch_array($cadena);
  	echo $row[0];
?>