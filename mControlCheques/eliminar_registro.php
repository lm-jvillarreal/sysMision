<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id_registro'];
	
    $cadena = mysqli_query($conexion,"UPDATE control_cheques SET activo = '0' WHERE id = '$id'");
    echo "ok";
?>