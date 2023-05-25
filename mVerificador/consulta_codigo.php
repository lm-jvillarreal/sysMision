<?php
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	$qry_nombre = "SELECT ARTC_DESCRIPCION, TO_CHAR(ARTD_ALTA,'DD-MM-YYYY') FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
	$st_nombre = oci_parse($conexion_central, $qry_nombre);
	oci_execute($st_nombre);
	$row_nombre = oci_fetch_row($st_nombre);
	echo utf8_encode(json_encode([
		$row_nombre[0],
		$row_nombre[1]
	]));
 ?>