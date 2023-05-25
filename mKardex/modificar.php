<?php
	include '../global_settings/conexion_oracle.php';
	//Agregamos la libreria para leer
	require_once('../plugins/PHPExcel/Classes/PHPExcel.php');
    require_once('../plugins/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');
	
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];
    $sucursal = $_POST['sucursal'];

	// Creamos un objeto PHPExcel
	$objPHPExcel = new PHPExcel();
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load('codigos.xlsx');
	// Indicamos que se pare en la hoja uno del libro
	$objPHPExcel->setActiveSheetIndex(0);
	
	//Leer codigos
	$totalregistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	for ($i = 2; $i <= $totalregistros; $i++) {
                $codigo = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();

                $sql_datos_artc = "SELECT 
                					artc_articulo, 
                					artc_descripcion, 
                					artc_familia, 
                					artn_estatus, 
                					artc_impuesto1, 
                					artc_impuesto2, 
                					com_familias.famc_descripcion as familia,
									(SELECT f.famc_descripcion FROM com_familias f WHERE f.famc_familia = com_familias.famc_familiapadre) AS departamento
									FROM com_articulos INNER JOIN com_familias ON com_familias.famc_familia = com_articulos.artc_familia
									WHERE com_articulos.artc_articulo = '$codigo'";
				$st_codigo = oci_parse($conexion_central, $sql_datos_artc);
				oci_execute($st_codigo);
				$row_codigo = oci_fetch_row($st_codigo);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $row_codigo[1]);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $row_codigo[7]);


                $sql_entradas = "SELECT NVL(sum(rm.rmon_cantsurtida),0) 
								FROM inv_movimientos m
								INNER JOIN inv_renglones_movimientos rm 
								ON rm.modn_folio = m.modn_folio 
								AND m.almn_almacen = rm.almn_almacen 
								AND m.modc_tipomov = rm.modc_tipomov 
								WHERE m.modc_tipomov IN ('AJUPOS', 'RAPOS', 'ECHORI','EGRAL','ENTCOC', 'ENTMEQ','ENTPRE','ENTSOC', 'ETRANS','ETRASE','EXCONV','EXDEV')
								AND m.MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicial', 'YYYY/MM/DD'))
								AND m.MOVD_FECHAAFECTACION < TRUNC (TO_DATE ('$fecha_final', 'YYYY/MM/DD')) + 1
								AND rm.ARTC_ARTICULO = '$codigo'
								AND m.almn_almacen = '$sucursal'";
				$exSql_entradas = oci_parse($conexion_central, $sql_entradas);
				oci_execute($exSql_entradas);
				$row_entradas = oci_fetch_row($exSql_entradas);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $row_entradas[0]);

                $sql_salidas = "SELECT NVL(sum(rm.rmon_cantsurtida), 0)
								FROM inv_movimientos m
								INNER JOIN inv_renglones_movimientos rm 
								ON rm.modn_folio = m.modn_folio 
								AND m.almn_almacen = rm.almn_almacen 
								AND m.modc_tipomov = rm.modc_tipomov 
								WHERE m.modc_tipomov IN ('SALMEQ', 'SALXVE
								','SGRAL', 	'STRANS', 	'STRASE', 	'SVALPR',	'SXCONV',	'SXMBOD', 	'SXMCAR', 	'SXMPAN',	'SXMTOR',	'SXROB',	'TRADEP',	
								'VALCI',	'DEVCTR',	'DEVXCO','DMPROV', 'AJUNEG', 'RANEG', 'SXMCAD')
								AND m.MOVD_FECHAAFECTACION >= TRUNC (TO_DATE ('$fecha_inicial', 'YYYY/MM/DD'))
								AND m.MOVD_FECHAAFECTACION < TRUNC (TO_DATE ('$fecha_final', 'YYYY/MM/DD')) + 1
								AND rm.ARTC_ARTICULO = '$codigo'
								AND m.almn_almacen = '$sucursal'";
				$exSql_salidas = oci_parse($conexion_central, $sql_salidas);
				oci_execute($exSql_salidas);
				$row_salidas = oci_fetch_row($exSql_salidas);
				$sql_pendiente = "SELECT NVL(SUM(a.RMON_CANTSURTIDA), 0) 
								    FROM INV_RENGLONES_MOVIMIENTOS a 
								    WHERE a.artc_articulo = '$codigo' 
								    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'SALXVE' AND ALMN_ALMACEN = '$sucursal'";
			    $st_pendientes = oci_parse($conexion_central, $sql_pendiente);
			    oci_execute($st_pendientes);

			    $row_pend = oci_fetch_row($st_pendientes);
			    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, $row_pend[0]);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $row_salidas[0]);
				$string  = "=(D" . $i . "+E" . $i . ")". "-F" . $i;
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $i, $string);
            }

	//Modificamos los valoresde las celdas A2, B2 Y C2
	// $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Nuevos Dulces');
	// $objPHPExcel->getActiveSheet()->SetCellValue('B2', 8.30);
	// $objPHPExcel->getActiveSheet()->SetCellValue('C2', 10);
	
	// //Agregamos nuevos valores en las celdas A7, B7 y C7
	// $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Nuevo Producto');
	// $objPHPExcel->getActiveSheet()->SetCellValue('B7', 10);
	// $objPHPExcel->getActiveSheet()->SetCellValue('C7', 2);
	
	//Guardamos los cambios
	// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	 //$objWriter->save("Archivo_salida.xlsx");
    	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Estado de resultados.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>