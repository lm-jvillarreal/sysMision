<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	//include '../global_settings/conexion_pruebas.php';
	include '../global_seguridad/verificar_sesion.php';
	$Id = $_POST["id"];
	$sql = "UPDATE AuditoriaConteo SET Estatus = 0 where Id = $Id";
	//$sql = "DELETE FROM AuditoriaConteo WHERE Id = $Id";
		$x  = mysqli_query($conexion, $sql);
	echo "$sql";
	
	//echo "$sql";
	
 ?>