<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	//include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	$consecutivo = $_POST['consecutivo'];
	$estante = $_POST['estante'];
	$codigo= $_POST['codigo'];
	$sql_o = "SELECT descripcion FROM productos WHERE codigo_producto = '$codigo'";
	$exsql = mysqli_query($conexion, $sql_o);
	$row = mysqli_fetch_row($exsql);	
	if ($row[0] == "") {
		echo "false";
	}else{
		$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '$consecutivo', '$estante', '$codigo', CURRENT_DATE, CURRENT_TIME, '$row[0]')";
		$x  = mysqli_query($conexion, $sql);
		echo "$row[0]";	
	}
	
	//echo "$sql";
	
 ?>