<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	//include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	// $id_mapeo = $_POST['id_mapeo'];
	// $codigo= $_POST['codigo'];
	// $descripcion = $_POST['descripcion'];
	// $cantidad_nueva = $_POST['cantidad_nueva'];
	// $cantidad_antig = $_POST['cantidad_antig'];
	// $cantidad = $cantidad_nueva - $cantidad_antig;
	// $id_renglon = $_POST['id_renglon'];


	$sql = "UPDATE AuditoriaConteo SET Estatus = 0 where Id = $Id";
	//$sql = "DELETE FROM AuditoriaConteo WHERE Id = $Id";
	$x  = mysqli_query($conexion, $sql);
	

	

	


	

	
	



	
	if ($row[0] == "") {
		echo "false";
	}else{
		echo "$row[0]";	
	}
	
	//echo "$sql";
	
 ?>