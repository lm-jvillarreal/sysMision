<?php
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');	
	$qry_nombre = "SELECT
						TO_CHAR (ARTD_ALTA, 'DD/MM/YYYY'),
						ARTC_UNIMEDIDA_USO,
						CPSC_CLAVE,
						CASE
					WHEN ARTN_ESTATUS = '1' THEN
						'ALTA'
					WHEN ARTN_ESTATUS = '2' THEN
						'BAJA'
					WHEN ARTN_ESTATUS = '3' THEN
						'OBSOLETO'
					END,
					 fams.FAMC_DESCRIPCION AS FAMILIA,
					 (
						SELECT
							FAMC_DESCRIPCION
						FROM
							COM_FAMILIAS
						WHERE
							COM_FAMILIAS.FAMC_FAMILIA = FAMS.FAMC_FAMILIAPADRE
					)
					FROM
						COM_ARTICULOS
					INNER JOIN COM_FAMILIAS fams ON COM_ARTICULOS.ARTC_FAMILIA = FAMS.FAMC_FAMILIA
					WHERE
						ARTC_ARTICULO = '$codigo'";
	$st_nombre = oci_parse($conexion_central, $qry_nombre);
	oci_execute($st_nombre);
	$row_nombre = oci_fetch_row($st_nombre);
	$array_datos  = array($row_nombre[0], $row_nombre[1], $row_nombre[2], $row_nombre[3], $row_nombre[4], $row_nombre[5]);
	$array_json = json_encode($array_datos);
	echo "$array_json";
 ?>