<?php 
	include '../configuracion/conexion_servidor.php';
	$id_persona = $_POST['id_persona'];
	$id_manual = $_POST['id_manual'];
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');

	$insert = "INSERT INTO usuarios_manuales (id_manual, id_usuario, fecha, hora) VALUES ('$id_manual', '$id_persona', '$fecha', '$hora')";
	$exInsert = mysqli_query($conexion_mysql, $insert);
	echo "$insert";

 ?>