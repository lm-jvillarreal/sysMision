<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	$sql = "SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st = oci_parse($conexion_central, $sql);
	oci_execute($st);
	$row = oci_fetch_row($st);
	echo "$row[0]";
 ?>