<?php 
	include 'conexion_servidor.php';
	$fecha_inicial = $_POST['fecha_inicial'];
	$fecha_final = $_POST['fecha_final'];
	$codigo = $_POST['codigo'];
	$fecha_i=str_replace("-","",$fecha_inicial);
	$fecha_fin=str_replace("-","",$fecha_final);
	ini_set('max_execution_time', 1000); 
	$qry_compras = "SELECT
						SUM (RMON_CANTSURTIDA)
					FROM
						INV_RENGLONES_MOVIMIENTOS
					INNER JOIN INV_MOVIMIENTOS ON INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = INV_MOVIMIENTOS.MODN_FOLIO
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
					)";
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
					AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
					WHERE 
					    ARTC_ARTICULO = '$codigo'
					AND
					    INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
					        TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
					    )
					AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
					    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
					) + 1
					AND (INV_MOVIMIENTOS.MODC_TIPOMOV = 'APENTR' OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ENTTRA' OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ETRAAC' OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS' OR INV_MOVIMIENTOS.MODC_TIPOMOV= 'ETRANS' OR INV_MOVIMIENTOS.MODC_TIPOMOV= 'ASTRAN' OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'ETRAN')
					AND (INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'APENTR' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTTRA' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ETRAAC' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'STRANS' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV= 'ETRANS' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV= 'ASTRAN' OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ETRAN')";
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
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
						AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
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
						)";
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
								AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
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
								)";
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
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
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
							)";
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
						AND (TIK.TICN_ESTATUS = 2 or TIK.TICN_ESTATUS = 3)";
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
						AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
						AND '$fecha_fin'
						AND (TIK.TICN_ESTATUS = 2)";
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
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
							WHERE
							    ARTC_ARTICULO = '$codigo'
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC (
							    TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
							)
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC (
							    TO_DATE ('$fecha_final', 'YYYY/MM/DD')
							) + 1
							AND (
							    INV_MOVIMIENTOS.MODC_TIPOMOV = 'ANSATR'
							    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SALART'
							    OR INV_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'
							)
							AND (
							    INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ANSATR'
							    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SALART'
							    OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'SALTRA'
							)";
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
					AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
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
					)";
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
									AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
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
									)";
		$st_dev_compra = oci_parse($conexion_central, $qry_devolucion_compra);
		oci_execute($st_dev_compra);
		$row_dev_compra = oci_fetch_row($st_dev_compra);
		if (is_null($row_dev_compra[0])) {
			$row_dev_compra[0] = 0;
		}else{
			$row_dev_compra[0] = $row_dev_compra[0];
		}
		$qry_existencia = "SELECT 
						    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '1', 200 ) +
						    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '2', 200 )+
						    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '3', 200 )+
						    spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '4', 200 ) AS existencia
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
							AND mapeo.fecha_conteo = '$fecha_final'";
		$exQry = mysqli_query($conexion, $qry_inventario);
		$row_inventario = mysqli_fetch_row($exQry);
		if (is_null($row_inventario[0])) {
			$row_inventario[0] = 0;
		}else{
			$row_inventario[0] = $row_inventario[0];
		}

		$qry_sin_afectar = "SELECT
								COUNT(ARTC_ARTICULO)
							FROM
								INV_RENGLONES_MOVIMIENTOS
							WHERE
								RMON_ESTATUS = 2
							AND MODC_TIPOMOV = 'SALXVE'
							AND ARTC_ARTICULO = '$codigo'";
		$st_sin_afectar = oci_parse($conexion_central, $qry_sin_afectar);
		oci_execute($st_sin_afectar);
		$row_sin_afectar = oci_fetch_row($st_sin_afectar);
		if (is_null($row_sin_afectar[0])) {
			$row_sin_afectar[0] = 0;
		}else{
			$row_sin_afectar[0] = $row_sin_afectar[0];
		}
		$array_datos = array($row_compras[0], $row_traspasos[0], $row_altas_inv[0],$row_dev_venta[0], $row_forza[0], $row_ventas[0], $row_sal_transf[0], $row_bajas[0], $row_dev_compra[0], $row_existencia[0], $row_inventario[0], $row_ventas_na[0], $row_sin_afectar[0]);
		$array_encode = json_encode($array_datos);
	echo "$array_encode";
 ?>