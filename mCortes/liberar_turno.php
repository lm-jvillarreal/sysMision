<?php 
	include 'conexion_servidor.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	$id = $_POST['id_turno'];
	$sql = "UPDATE turnos SET estatus = 2, hora_fin = '$hora' WHERE id = '$id'";
	$exSql = mysqli_query($conexion, $sql);
 ?>