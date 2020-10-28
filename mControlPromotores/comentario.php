<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('H:i:s');

	$comentario  = $_POST['comentario'];
	$id_registro = $_POST['id_registro'];
  
	$cadena = mysqli_query($conexion,"UPDATE registro_actividades SET comentario = '$comentario' WHERE id = '$id_registro'");
	echo "ok";
?>