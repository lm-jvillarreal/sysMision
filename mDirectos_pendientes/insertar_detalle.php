<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	//$consecutivo = $_POST['consecutivo'];
	//$estante = $_POST['estante'];
	$cantidad = $_POST['cantidad'];
	$codigo= $_POST['codigo'];
	$consecutivo = $_POST['consecutivo'];

	//consulta infofin
	$sql_o = "SELECT artc_descripcion FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st = oci_parse($conexion_central, $sql_o);
	oci_execute($st);
	$row = oci_fetch_row($st);

	if ($row[0] == "") {
		echo "false";
	}else{
		$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '$consecutivo', '1', '$codigo', CURRENT_DATE, CURRENT_TIME, '$row[0]')";
		$exSql = mysqli_query($conexion, $sql);
		//echo "$sql";
		$sql_max = "SELECT MAX(id) FROM inv_detalle_mapeo";
		$e = mysqli_query($conexion, $sql_max);
		$r_max = mysqli_fetch_row($e);
		//Agregar datos a tabla de captura
		$sql_captura = "INSERT INTO inv_captura(id_mapeo, id_detalle_mapeo, cod_producto, cantidad, usuario) VALUES('$id_mapeo', '$r_max[0]', '$codigo', '$cantidad', '1')";
		$exCaptura = mysqli_query($conexion, $sql_captura);
		echo "$row[0]";	
	}

	
	
	
	//echo "$sql";
	//$exSql = mysqli_query($conexion, $sql);
 ?>