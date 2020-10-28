<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('H:i:s');

	$cajas        = $_POST['cajas'];
	$id_actividad = $_POST['id_actividad'];

	$cadena = mysqli_query($conexion,"SELECT id FROM registro_actividades WHERE id_actividad = '$id_actividad' AND fecha = '$fecha'");
	$row = mysqli_fetch_array($cadena);
  
	$cadena = mysqli_query($conexion,"UPDATE registro_actividades SET cajas_surtidas = '$cajas' WHERE id = '$id_actividad'");
	echo "ok";
?>