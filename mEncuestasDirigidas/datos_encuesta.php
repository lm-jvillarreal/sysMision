<?php
	include '../global_settings/conexion.php';

	$id = $_POST['id'];
	 // echo "SELECT nombre FROM n_encuestas WHERE folio = '$id'";
	$cadena = mysqli_query($conexion,"SELECT nombre FROM n_encuestas WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);
	echo $row[0];
?>