<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("H:i:s");

	$id  = $_POST['id'];
	// $cadena = mysqli_query($conexion,"SELECT id FROM actividades_usuario WHERE folio = '$folio' ANd principal = '0' AND id_usuario = '$id_usuario'");
	// echo "SELECT id FROM actividades_usuario WHERE folio = '$folio' ANd principal = '0' AND id_usuario = '$id_usuario'";
	// $row    = mysqli_fetch_array($cadena);
	$cadena = mysqli_query($conexion,"UPDATE actividades_usuario SET hora_inicio = '$hora', cronometro = '1' WHERE id = '$id'");
	// echo "UPDATE actividades_usuario SET hora_inicio = '$hora', cronometro = '1' WHERE id = '$row[0]'";
 //    echo "ok";
?>