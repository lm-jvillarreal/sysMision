<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id = $_POST['id_registro'];
	
	$cadena_modificar="UPDATE tiempo_extra SET activo = '0' WHERE id = '$id'";
    $cadena = mysqli_query($conexion,$cadena_modificar);
    echo "ok";
?>