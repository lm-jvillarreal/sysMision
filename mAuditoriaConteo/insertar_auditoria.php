<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	//include '../global_settings/conexion_pruebas.php';
	include '../global_seguridad/verificar_sesion.php';

	$IdDetalleMapeo = $_POST["IdDetalleMapeo"];
	$IdCaptura = $_POST["IdCaptura"];
	$CantidadAnterior = $_POST["CantidadAnterior"];
	$CantidadNueva = $_POST["CantidadNueva"];

	$sql = "INSERT INTO AuditoriaConteo(IdDetalleMapeo, IdCaptura, CantidadAnterior, CantidadNueva, Usuario) 
				VALUES('$IdDetalleMapeo', '$IdCaptura', '$CantidadAnterior', '$CantidadNueva', '$id_usuario')";
		$x  = mysqli_query($conexion, $sql);
	
	
	//echo "$sql";
	
 ?>