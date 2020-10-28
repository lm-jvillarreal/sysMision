<?php 
	include '../global_settings/conexion_oracle.php';
	include '../global_settings/conexion_supsys.php';
	error_reporting(E_ALL ^ E_NOTICE);
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');
	$fecha_inicial = $_POST['fecha_inicial'];
	$fecha_final = $_POST['fecha_final'];
	$codigo = $_POST['codigo'];
	$sucursal = $_POST['sucursal'];
	$sucursal_admin = $_POST['sucursal_admin'];
	if ($sucursal_admin == "") {
		$almacen = $sucursal;
	}else{
		$almacen = $sucursal_admin;
	}

	$a_separado = $almacen . "00";
	$fecha_i=str_replace("-","",$fecha_inicial);
	$fecha_fin=str_replace("-","",$fecha_final);
	$fecha_1=str_replace("-","",$fecha);
	ini_set('max_execution_time', 1000);

	$qry_compras = "SELECT
						SUM (RMON_CANTSURTIDA)
					FROM
						INV_RENGLONES_MOVIMIENTOS
					INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
					AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = INV_MOVIMIENTOS.MODC_TIPOMOV
					WHERE
						ARTC_ARTICULO = '$codigo'
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
						TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
					)
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
						TO_DATE ('$fecha_final', 'YYYY/MM/DD')
					) + 1
					AND (
						INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTSOC'
						OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTCOC'
						OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ESCARG'
					)
					AND (
						INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTSOC'
						OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTCOC'
						OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ESCARG'
					)
					AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
	$st_compras = oci_parse($conexion_central, $qry_compras);
	oci_execute($st_compras);
	$row_compras = oci_fetch_row($st_compras);
	if (is_null($row_compras[0])) {
		$row_compras[0] = 0;
	}else{
		$row_compras[0] = $row_compras[0];
	}

	$qry_traspasos = "SELECT 
					    SUM(RMON_CANTSURTIDA) 
					FROM 
					    INV_RENGLONES_MOVIMIENTOS
					INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
					WHERE 
					    ARTC_ARTICULO = '$codigo'
					AND
					    INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
					        TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
					    )
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
					    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
					) + 1
					AND (INV_MOVIMIENTOS.MODC_TIPOMOV = 'ETRANS' OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ETRASE')
					AND (INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ETRANS' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ETRASE' )
					AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_traspasos = oci_parse($conexion_central, $qry_traspasos);
		oci_execute($st_traspasos);
		$row_traspasos = oci_fetch_row($st_traspasos);
		if (is_null($row_traspasos[0])) {
			$row_traspasos[0] = 0;
		}else{
			$row_traspasos[0] = $row_traspasos[0];
		}

		$qry_altas_inv ="SELECT
							SUM (RMON_CANTSURTIDA)
						FROM
							INV_RENGLONES_MOVIMIENTOS
						INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
						AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
						AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = INV_MOVIMIENTOS.MODC_TIPOMOV
						WHERE
							ARTC_ARTICULO = '$codigo'
						AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
							TO_DATE (
								'$fecha_inicial',
								'YYYY/MM/DD'
							)
						)
						AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
							TO_DATE (
								'$fecha_final',
								'YYYY/MM/DD'
							)
						) + 1
						AND (
							INV_MOVIMIENTOS.MODC_TIPOMOV = '1ENPRM'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'AJUPOS'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EAJINS'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ECACSG'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ECHORI'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EMTTO'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTPRE'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTPRO'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EXCOMP'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EXCONV'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EXVIGI'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SALINI'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'AJPINI'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EDEVVA'
							OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EACAJC'
						    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'E_AJCP'
						    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'INRELE'
						    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EGRAL'
						)
						AND (
							INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = '1ENPRM'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'AJUPOS'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EAJINS'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ECACSG'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ECHORI'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EMTTO'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTPRE'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTPRO'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EXCOMP'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EXCONV'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EXVIGI'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SALINI'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'AJPINI'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EDEVVA'
							OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EACAJC'
						    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'E_AJCP'
						    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'INRELE'
						    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EGRAL'
						)
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
						AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_altas_inv = oci_parse($conexion_central, $qry_altas_inv);
		oci_execute($st_altas_inv);
		$row_altas_inv = oci_fetch_row($st_altas_inv);
		if (is_null($row_altas_inv[0])) {
			$row_altas_inv[0] = 0;
		}else{
			$row_altas_inv[0] = $row_altas_inv[0];
		}

		$qry_devolucion_venta = "SELECT
									SUM (RMON_CANTSURTIDA)
								FROM
									INV_RENGLONES_MOVIMIENTOS
								INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
								AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
								WHERE
									ARTC_ARTICULO = '$codigo'
								AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
									TO_DATE (
										'$fecha_inicial',
										'YYYY/MM/DD'
									)
								)
								AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
									TO_DATE (
										'$fecha_final',
										'YYYY/MM/DD'
									)
								) + 1
								AND (
									INV_MOVIMIENTOS.MODC_TIPOMOV = 'EDACSG'
									OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'EXDEV'
								)
								AND (
									INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EDACSG'
									OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'EXDEV'
								)
								AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
								AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_dev_venta = oci_parse($conexion_central, $qry_devolucion_venta);
		oci_execute($st_dev_venta);
		$row_dev_venta = oci_fetch_row($st_dev_venta);
		if (is_null($row_dev_venta[0])) {
			$row_dev_venta[0] = 0;
		}else{
			$row_dev_venta[0] = $row_dev_venta[0];
		}

		$qry_ajustes_forz = "SELECT
								SUM (RMON_CANTSURTIDA)
							FROM
								INV_RENGLONES_MOVIMIENTOS
							INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
							WHERE
								ARTC_ARTICULO = '$codigo'
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
								TO_DATE (
									'$fecha_inicial',
									'YYYY/MM/DD'
								)
							)
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
								TO_DATE (
									'$fecha_final',
									'YYYY/MM/DD'
								)
							) + 1
							AND (
								INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTGRA'
							)
							AND (
								INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTGRA'
							)
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_forza = oci_parse($conexion_central, $qry_ajustes_forz);
		oci_execute($st_forza);
		$row_forza = oci_fetch_row($st_forza);
		if (is_null($row_forza[0])) {
			$row_forza[0] = 0;
		}else{
			$row_forza[0] = $row_forza[0];
		}

		$qry_ventas = "SELECT
							SUM (DETALLE.ARTN_CANTIDAD)
						FROM
							PV_ARTICULOSTICKET detalle
						INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
						AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
						WHERE
							DETALLE.ARTC_ARTICULO = '$codigo'
						AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
						AND '$fecha_fin'
						AND (
							TIK.TICN_ESTATUS = 2
							OR TIK.TICN_ESTATUS = 3
						)
						AND tik.TICC_SUCURSAL = '$almacen'
						AND DETALLE.TICC_SUCURSAL = '$almacen'";
		$st_ventas = oci_parse($conexion_central, $qry_ventas);
		oci_execute($st_ventas);
		$row_ventas = oci_fetch_row($st_ventas);
		if (is_null($row_ventas[0])) {
			$row_ventas[0] = 0;
		}else{
			$row_ventas[0] = $row_ventas[0];
		}

		$qry_ventas_na = "SELECT
						    SUM (DETALLE.ARTN_CANTIDAD)
						FROM
						    PV_ARTICULOSTICKET detalle
						INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
						AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
						WHERE
						    DETALLE.ARTC_ARTICULO = '$codigo'
						AND TIK.ticn_aaaammddventa BETWEEN '$fecha_1'
						AND '$fecha_1'
						AND (TIK.TICN_ESTATUS = 2)
						AND tik.TICC_SUCURSAL = '$almacen'
						AND DETALLE.TICC_SUCURSAL = '$almacen'";
		$st_ventas_na = oci_parse($conexion_central, $qry_ventas_na);
		oci_execute($st_ventas_na);
		$row_ventas_na = oci_fetch_row($st_ventas_na);
		if (is_null($row_ventas_na[0])) {
			$row_ventas_na[0] = 0;
		}else{
			$row_ventas_na[0] = $row_ventas_na[0];
		}

		$qry_salidas_transf ="SELECT
							    SUM (RMON_CANTSURTIDA)
							FROM
							    INV_RENGLONES_MOVIMIENTOS
							INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
							WHERE
							    ARTC_ARTICULO = '$codigo'
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
							    TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
							)
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
							    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
							) + 1
							AND (
							    INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS'
							    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRASE'
							)
							AND (
							    INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS'
							    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRASE'
							)
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_salidas_transf = oci_parse($conexion_central, $qry_salidas_transf);
		oci_execute($st_salidas_transf);
		$row_sal_transf = oci_fetch_row($st_salidas_transf);
		if (is_null($row_sal_transf[0])) {
			$row_sal_transf[0] = 0;
		}else{
			$row_sal_transf[0] = $row_sal_transf[0];
		}

		$qry_bajas = "SELECT
						SUM (RMON_CANTSURTIDA)
					FROM
						INV_RENGLONES_MOVIMIENTOS
					INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
					AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = INV_MOVIMIENTOS.MODC_TIPOMOV
					WHERE
						ARTC_ARTICULO = '$codigo'
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
						TO_DATE (
							'$fecha_inicial',
							'YYYY/MM/DD'
						)
					)
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
						TO_DATE (
							'$fecha_final',
							'YYYY/MM/DD'
						)
					) + 1
					AND (
						INV_MOVIMIENTOS.MODC_TIPOMOV = 'AJUNEG'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SACAJC'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'S_AJCP'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SCACSG'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SDACSG'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'INRELS'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'VALALM'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SVALPR'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'VALCI'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'VREFAC'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'DEVXCO'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'TRADEP'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SCHORI'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SGRAL'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXCONV'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRAAC'
					    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'DEVVAL'
					)
					AND (
						INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'AJUNEG'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SACAJC'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'S_AJCP'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SCACSG'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SDACSG'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'INRELS'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'VALALM'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SVALPR'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'VALCI'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'VREFAC'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'DEVXCO'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'TRADEP'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SCHORI'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SGRAL'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SXCONV'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRAAC'
					    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'DEVVAL'
					)
					AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
					AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_bajas = oci_parse($conexion_central, $qry_bajas);
		oci_execute($st_bajas);
		$row_bajas = oci_fetch_row($st_bajas);
		if (is_null($row_bajas[0])) {
			$row_bajas[0] = 0;
		}else{
			$row_bajas[0] = $row_bajas[0];
		}

		$qry_devolucion_compra = "SELECT
										SUM (RMON_CANTSURTIDA)
									FROM
										INV_RENGLONES_MOVIMIENTOS
									INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
									AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
									WHERE
										ARTC_ARTICULO = '$codigo'
									AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
										TO_DATE (
											'$fecha_inicial',
											'YYYY/MM/DD'
										)
									)
									AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
										TO_DATE (
											'$fecha_final',
											'YYYY/MM/DD'
										)
									) + 1
									AND (
										INV_MOVIMIENTOS.MODC_TIPOMOV = 'DEVPRO'
									    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'DMPROV'
									    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'DECTR'
									)
									AND (
										INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'DEVPRO'
									    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'DMPROV'
									    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'DEVCTR'
									)
								AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
								AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_dev_compra = oci_parse($conexion_central, $qry_devolucion_compra);
		oci_execute($st_dev_compra);
		$row_dev_compra = oci_fetch_row($st_dev_compra);
		if (is_null($row_dev_compra[0])) {
			$row_dev_compra[0] = 0;
		}else{
			$row_dev_compra[0] = $row_dev_compra[0];
		}
		$qry_existencia = "SELECT 
						    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$almacen', '$codigo' ) AS existencia
							FROM dual";
		$st_existencia = oci_parse($conexion_central, $qry_existencia);
		oci_execute($st_existencia);
		$row_existencia = oci_fetch_row($st_existencia);
		if (is_null($row_existencia[0])) {
			$row_existencia[0] = 0;
		}else{
			$row_existencia[0] = $row_existencia[0];
		}
		$qry_inventario = "SELECT
							SUM(captura.cantidad)
							FROM
								captura
							INNER JOIN mapeo ON mapeo.id = captura.id_mapeo
							WHERE
								cod_producto = '$codigo'
							AND mapeo.fecha_conteo = '$fecha_final'
							AND mapeo.id_sucursal = '$almacen'";
		$exQry = mysqli_query($conexion, $qry_inventario);
		$row_inventarios = mysqli_fetch_row($exQry);
		if (is_null($row_inventarios[0])) {
			$row_inventarios[0] = 0;
		}else{
			$row_inventarios[0] = $row_inventarios[0];
		}

		$qry_inv_inicial = "SELECT
								cantidad
							FROM
								detalle_existencia
							INNER JOIN existencias ON existencias.id = detalle_existencia.id_existencia
							WHERE
								detalle_existencia.codigo = '$codigo'
							AND existencias.fecha = '$fecha_inicial'
							AND existencias.id_sucursal = '$almacen'";
		$ex_qry_inv_ini = mysqli_query($conexion, $qry_inv_inicial);
		$row_inv_ini = mysqli_fetch_row($ex_qry_inv_ini);
		if (is_null($row_inv_ini[0])) {
			$row_inv_ini[0] = 0;
		}else{
			$row_inv_ini[0] = $row_inv_ini[0];
		}

		$qry_sin_afectar = "SELECT
								COUNT(ARTC_ARTICULO)
							FROM
								INV_RENGLONES_MOVIMIENTOS
							WHERE
								RMON_ESTATUS = 2
							AND MODC_TIPOMOV = 'SALXVE'
							AND ALMN_ALMACEN = '$almacen'
							AND ARTC_ARTICULO = '$codigo'";
		$st_sin_afectar = oci_parse($conexion_central, $qry_sin_afectar);
		oci_execute($st_sin_afectar);
		$row_sin_afectar = oci_fetch_row($st_sin_afectar);
		if (is_null($row_sin_afectar[0])) {
			$row_sin_afectar[0] = 0;
		}else{
			$row_sin_afectar[0] = $row_sin_afectar[0];
		}
		$qry_astrans = "SELECT 
							SUM(INV_RENGLONES_MOVIMIENTOS.rmon_cantsurtida)
						FROM INV_RENGLONES_MOVIMIENTOS 
						INNER JOIN INV_MOVIMIENTOS
						ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO 
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
						WHERE 
						    INV_MOVIMIENTOS.MODC_TIPOMOV = 'ASTRAN'
						AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ASTRAN'
						AND ARTC_ARTICULO = '$codigo'
						AND
						    INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
						        TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
						    )
						AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
						    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
						) + 1
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
						AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_astrans = oci_parse($conexion_central, $qry_astrans);
		oci_execute($st_astrans);
		$row_astrans = oci_fetch_row($st_astrans);
		if (is_null($row_astrans[0])) {
			$row_astrans[0] = 0;
		}else{
			$row_astrans[0] = $row_astrans[0];
		}
		$qry_aetrans = "SELECT 
							SUM(INV_RENGLONES_MOVIMIENTOS.rmon_cantsurtida)
						FROM INV_RENGLONES_MOVIMIENTOS 
						INNER JOIN INV_MOVIMIENTOS
						ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO 
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
						WHERE 
						    INV_MOVIMIENTOS.MODC_TIPOMOV = 'AETRAN'
						AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'AETRAN'
						AND ARTC_ARTICULO = '$codigo'
						AND
						    INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
						        TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
						    )
						AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
						    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
						) + 1
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
						AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_aetrans = oci_parse($conexion_central, $qry_aetrans);
		oci_execute($st_aetrans);
		$row_aetrans = oci_fetch_row($st_aetrans);
		if (is_null($row_aetrans[0])) {
			$row_aetrans[0] = 0;
		}else{
			$row_aetrans[0] = $row_aetrans[0];
		}
	$qry_mermas = "SELECT 
		sum(INV_RENGLONES_MOVIMIENTOS.rmon_cantsurtida)
				FROM INV_RENGLONES_MOVIMIENTOS 
				INNER JOIN INV_MOVIMIENTOS
				ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO 
				AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
				AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
				INNER JOIN INV_TIPOS_MOVIMIENTO ON INV_TIPOS_MOVIMIENTO.TMOC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
				WHERE ARTC_ARTICULO = '$codigo'
				AND (
							LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmbod'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmcar'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmedo'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmfci'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmfta'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmpan'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmtor'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmvar'
							OR LOWER(INV_MOVIMIENTOS.MODC_TIPOMOV) = 'sxrob'
						)
						AND (
							LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmbod'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmcar'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmedo'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmfci'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmfta'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmpan'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmtor'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxmvar'
							OR LOWER(INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV) = 'sxrob'
						)
				AND
				    INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
				        TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
				    )
				AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
				    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
				) + 1
				AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
				AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_mermas = oci_parse($conexion_central, $qry_mermas);
		oci_execute($st_mermas);
		$row_mermas = oci_fetch_row($st_mermas);
		if (is_null($row_mermas[0])) {
			$row_mermas[0] = 0;
		}else{
			$row_mermas[0] = $row_mermas[0];
		}
		$qry_separado = "SELECT spin_articulos.fn_existencia_disponible_todos (
					13,
					NULL,
					NULL,
					1,
					1,
					'$a_separado',
					'$codigo'
				) FROM dual";
		$st_separado = oci_parse($conexion_central, $qry_separado);
		oci_execute($st_separado);
		$row_separado = oci_fetch_row($st_separado);

		///////////////////////////////////
		$qry_salidas_restaurante ="SELECT
							    SUM (RMON_CANTSURTIDA)
							FROM
							    INV_RENGLONES_MOVIMIENTOS
							INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = INV_MOVIMIENTOS.ALMN_ALMACEN
							WHERE
							    ARTC_ARTICULO = '$codigo'
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
							    TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
							)
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
							    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
							) + 1
							AND (
							     INV_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'
							)
							AND (
							    INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'
							)
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$almacen'";
		$st_salidas_restaurante = oci_parse($conexion_central, $qry_salidas_restaurante);
		oci_execute($st_salidas_restaurante);
		$row_sal_restaurante = oci_fetch_row($st_salidas_restaurante);
		if (is_null($row_sal_restaurante[0])) {
			$row_sal_restaurante[0] = 0;
		}else{
			$row_sal_restaurante[0] = $row_sal_restaurante[0];
		}
		///////////////////////////////
		$array_datos = array(
			$row_compras[0],//0 
			$row_traspasos[0],//1
			 $row_altas_inv[0],//2
			 $row_dev_venta[0], //3
			 $row_forza[0], //4
			 $row_ventas[0], //5
			 $row_sal_transf[0],//6
			  $row_bajas[0], //7
			  $row_dev_compra[0],//8
			   $row_existencia[0],//9
			    $row_inventarios[0],//10
			     $row_ventas_na[0], //11
			     $row_sin_afectar[0],//12
			      $row_mermas[0],//13
			      $row_aetrans[0],//14
			      $row_astrans[0],//15
			      $row_inv_ini[0],//16
			  	$row_separado[0],//17
			  	$row_sal_restaurante[0]);//18
		$array_encode = json_encode($array_datos);
	echo "$array_encode";
 ?>