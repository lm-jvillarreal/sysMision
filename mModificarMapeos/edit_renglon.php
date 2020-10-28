<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	// include '../global_settings/conexion_pruebas.php';
	// include '../global_settings/conexion_oracle.php';
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['txtIdRenglon'];
	$descripcion = $_POST['txtDescripcion'];
	$codigo= $_POST['txtCodProd'];

	$qry = "UPDATE inv_detalle_mapeo SET codigo_producto = '$codigo', descripcion = '$descripcion' WHERE id = $id ";
	
	//echo "$sql";
	$exSql = mysqli_query($conexion, $qry);
 ?>