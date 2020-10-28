<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	$consecutivo = $_POST['consecutivo'];
	$estante = $_POST['estante'];
	$codigo= $_POST['codigo'];
	$sql_o = "SELECT artc_descripcion FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st = oci_parse($conexion_central, $sql_o);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '$consecutivo', '$estante', '$codigo', CURRENT_DATE, CURRENT_TIME, '$row[0]')";
	if ($row[0] == "") {
		echo "false";
	}else{
		echo "$row[0]";	
	}
	
	//echo "$sql";
	$exSql = mysqli_query($conexion, $sql);
 ?>