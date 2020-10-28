<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');

	$fecha = date("Y-m-d"); 
	$hora  = date ("h:i:s");

	$id=$_POST['id'];
	$firma=$_POST['clave'];

	
	$cadena ="UPDATE tiempo_extra SET folio = '2' WHERE id = '$id'";
	 $cadena_modifica= mysqli_query($conexion,$cadena);
    echo "ok";
?>