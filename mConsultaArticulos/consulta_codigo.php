<?php
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	$m_of = 0;
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');	
	$qry_nombre = "SELECT
						ARTC_DESCRIPCION,
						ARTN_PRECIOVENTA,
						ARTN_PRECIO_ULTIMA_COMPRA,
						CASE
					WHEN ARTC_IMPUESTO1 = '16' THEN
						'16'
					WHEN ARTC_IMPUESTO1 = 'CERO' THEN
						'0'
					END,
					 CASE
					WHEN ARTC_IMPUESTO2 = 'CERO' THEN
						'0'
					WHEN ARTC_IMPUESTO2 = 'IEPS' THEN
						'8'
					END
					FROM
						COM_ARTICULOS
					WHERE
						ARTC_ARTICULO = '$codigo'";
	$st_nombre = oci_parse($conexion_central, $qry_nombre);
	oci_execute($st_nombre);
	$row_nombre = oci_fetch_row($st_nombre);
	$iva = ".".$row_nombre[3];
	$ieps = ".0".$row_nombre[4];
	$precio_impuestos = $row_nombre[1] + ($row_nombre[1] * $iva) + ($ieps * $row_nombre[1]);
	$qry_oferta = "SELECT
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
					AND C_O.coon_baja_sn = '0'
					AND A_F.aron_baja_sn = '0'
					ORDER BY C_O.COON_ID_OFERTA DESC";

	$st_oferta = oci_parse($conexion_central, $qry_oferta);
	oci_execute($st_oferta);
	$row_oferta = oci_fetch_row($st_oferta);

	if (is_null($row_oferta[0])) {
		$precio_f = 0;
	}else{
		if ($row_oferta[3] == 0) {
			//porcentaje
			$precio_f = $precio_impuestos - ($precio_impuestos * ($row_oferta[0] * .01));
			$precio_f = round($precio_f, 2);
		}else{
			//precio fijo
			$precio_f = $row_oferta[0];
			$precio_f = round($precio_f, 2);
		}
	}
	
	if (is_null($row_nombre[4])) {
		$row_nombre[4] = "0";
	}else{
		$row_nombre[4] = $row_nombre[4];
	}
	if($row_nombre[1]=='0' || is_null($row_nombre[1]) || $row_nombre[2]=='0' || is_null($row_nombre[2])){
		$margen=0;
	}else{
		$margen = 1 - ($row_nombre[2]/$row_nombre[1]);
	}
	
	$margen2 = $margen * 100;
	$margen2 = round($margen2, 1);
	if ($precio_f == 0) {
		$margen_oferta = 0;
	}else{
		$margen_oferta = 1 - ($row_nombre[2]/$precio_f);
		$m_of = $margen_oferta * 100;
		$m_of = round($m_of, 1);
	}


	$existencia = "SELECT
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 1, '$codigo') + 
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 2, '$codigo') + 
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 3, '$codigo') + 
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 4, '$codigo') +
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 5, '$codigo') +
					spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 99, '$codigo')
				FROM
					dual";
	$st_exis = oci_parse($conexion_central, $existencia);
	oci_execute($st_exis);
	$row_existencia = oci_fetch_row($st_exis);
	$array_datos  = array(
		$row_nombre[0], 
		$precio_f, 
		$row_nombre[2], 
		$row_oferta[2],
		money_format("%.2n", $precio_impuestos),
		$row_nombre[2], 
		$row_nombre[3], 
		$row_nombre[4], 
		$margen2, 
		$m_of,
		$row_existencia[0]);
	$array_json = json_encode($array_datos);
	echo "$array_json";
?>