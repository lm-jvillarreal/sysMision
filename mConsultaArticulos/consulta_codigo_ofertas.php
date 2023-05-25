<?php
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');	
	$oferta_do = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '1'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_do = oci_parse($conexion_central, $oferta_do);
	oci_execute($st_oferta_do);
	$row_oferta_do = oci_fetch_row($st_oferta_do);
	
	$oferta_arb = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '2'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_arb = oci_parse($conexion_central, $oferta_do);
	oci_execute($st_oferta_arb);

	$row_oferta_arb = oci_fetch_row($st_oferta_arb);
	$oferta_vil = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '3'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_vil = oci_parse($conexion_central, $oferta_vil);
	oci_execute($st_oferta_vil);
	$row_oferta_vil = oci_fetch_row($st_oferta_vil);
	
	$oferta_all = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '4'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_all = oci_parse($conexion_central, $oferta_all);
	oci_execute($st_oferta_all);	
	$row_oferta_all = oci_fetch_row($st_oferta_all);
	
	$oferta_pet = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '5'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_pet = oci_parse($conexion_central, $oferta_pet);
	oci_execute($st_oferta_pet);	
	$row_oferta_pet = oci_fetch_row($st_oferta_pet);

	$oferta_mm = "SELECT
						A_F.ARON_PORCDESCUENTOOPRECIO,
						TO_CHAR (
							C_O.COOD_VIGENCIA_INI,
							'DD/MM/YYYY'
						),
						TO_CHAR (
							C_O.COOD_VIGENCIA_FIN,
							'DD/MM/YYYY'
						),
						C_O.COON_TIPO
					FROM
						PV_ARTICULOS_OFERTA A_F
					INNER JOIN PV_CONFIGURACION_OFERTA C_O ON C_O.COON_ID_OFERTA = A_F.COON_ID_OFERTA
					WHERE
						C_O.COOD_VIGENCIA_FIN >= TRUNC (
							TO_DATE ('$fecha', 'YYYY/MM/DD')
						)
					AND A_F.AROC_ARTICULO = '$codigo'
					AND A_F.AROC_SUCURSAL = '6'
					AND A_F.ARON_BAJA_SN='0'
					ORDER BY A_F.ARON_PORCDESCUENTOOPRECIO ASC";
	$st_oferta_mm = oci_parse($conexion_central, $oferta_mm);
	oci_execute($st_oferta_mm);	
	$row_oferta_mm = oci_fetch_row($st_oferta_mm);	
	$array_datos  = array($row_oferta_do[0], $row_oferta_arb[0], $row_oferta_vil[0], $row_oferta_all[0], $row_oferta_pet[0], $row_oferta_mm[0]);
	$array_json = json_encode($array_datos);
	echo "$array_json";
 ?>