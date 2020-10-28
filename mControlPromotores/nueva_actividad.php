<?php 
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$hora  = date('H:i:s');

	$actividad   = $_POST['actividad'];
	$id_promotor = $_POST['id_promotor'];
  
	$cadena = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad,id_promotor,fecha,hora,id_usuario,activo,principal)
										VALUES ('$actividad','$id_promotor','$fecha','$hora','$id_usuario','1','0')");
	echo "ok";
?>