<?php 	
	//error_reporting(E_ALL ^ E_NOTICE);
	// include '../global_settings/conexion_pruebas.php';
	// include '../global_settings/conexion_oracle.php';
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
	$zona = $_POST["zona"];
	$mueble = $_POST["mueble"];
	$cara = $_POST["cara"];
	$fecha = $_POST["fecha"];
	$sucursal = $_POST["cmbSucursal"];
	$area = $_POST["cmbArea"];
	$qry = "UPDATE inv_mapeo SET zona = '$zona', id_area = $area, mueble='$mueble', cara= '$cara', id_sucursal = '$sucursal', fecha_conteo = '$fecha' WHERE id = $id";
	
	echo "$qry";
	$exSql = mysqli_query($conexion, $qry);
 ?>