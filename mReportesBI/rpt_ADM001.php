<?php
ini_set('memory_limit', '1024M');
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
include '../../global_settings/conexion.php';
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
//$sucursal = $_POST['sucursal'];
//$fecha_inicio = $_POST['fecha_inicial'];
//$fecha_final = $_POST['fecha_final'];


	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1800);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once '../../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte consolidado de desplazamiento")
								 ->setSubject("Administracion")
								 ->setDescription("Reporte de desplazamiento")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");

	for($i=0;$i<6;){
		//$i=$i+1;
		$sucursal=$i+1;
		
		$consulta_principal  = "SELECT
								( SELECT ALM.ALMN_ALMACEN FROM COM_ALMACENES ALM WHERE alm.ALMN_ALMACEN = '$sucursal' ) AS ALMACEN,
								( SELECT ALMC_NOMBRE FROM COM_ALMACENES ALM WHERE alm.ALMN_ALMACEN = '$sucursal' ) AS NOMBRE_ALMACEN,
								INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
								INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
								familias.FAMC_DESCRIPCION AS Familia,
								ROUND( INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA, 2 ) AS PVENTA,
								( SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
								( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, $sucursal, INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia,
								( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia_CEDIS,
								NVL((SELECT PROC_NOMBRE FROM CXP_PROVEEDORES prov INNER JOIN COM_ARTICULOSLISTAPRECIOS lista ON TRIM(prov.PROC_CVEPROVEEDOR)=TRIM(lista.PROC_CVEPROVEEDOR) WHERE lista.ARTC_ARTICULO=INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM=1),'NOLISTA') PROVEEDOR,
								NVL((SELECT prov.PROC_CVEPROVEEDOR FROM CXP_PROVEEDORES prov INNER JOIN COM_ARTICULOSLISTAPRECIOS lista ON TRIM(prov.PROC_CVEPROVEEDOR)=TRIM(lista.PROC_CVEPROVEEDOR) WHERE lista.ARTC_ARTICULO=INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM=1),'NOLISTA') CVEPROVEEDOR
								FROM
								INV_ARTICULOS_DETALLE
								INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
								WHERE
								INV_ARTICULOS_DETALLE.ARTN_ESTATUS = 1";
//echo "$consulta_principal"."<br>";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);
		// Add some data
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($i)
					->setCellValue('A1', 'N° SUCURSAL')
					->setCellValue('B1', 'SUCURSAL')
					->setCellValue('C1', 'SKU')
					->setCellValue('D1', 'DESCRIPCION')
					->setCellValue('E1', 'FABRICANTE')
					->setCellValue('F1', 'FAMILIA')
					->setCellValue('G1','PRECIO')
					->setCellValue('H1','PROMEDIOVENTA')
					->setCellValue('I1','Art8020')
					->setCellValue('J1','ClaveProvUltimoRecibo')
					->setCellValue('K1','NombreProvUltimoRecibo')
					->setCellValue('L1','Capacidad')
					->setCellValue('M1','ExistenciaTeorica')
					->setCellValue('N1','MciaTransito')
					->setCellValue('O1','Mercancia en Cedis')
					->setCellValue('P1','Faltante por proveedor (Fecha de último recibo en cedis )')
					->setCellValue('Q1','Fecha de último pedido')
					->setCellValue('R1','FecUltimoRecibo')
					->setCellValue('S1','FrecSurtido')
					->setCellValue('T1','DiasInveObj')
					->setCellValue('U1','DiasInvReal')
					->setCellValue('V1','DiasDeDesabastoEntienda')
					->setCellValue('W1','DiasSinVenta')
					->setCellValue('X1','MotivoDesabasto')
					->setCellValue('Y1','ViaDeAbasto')
					->setCellValue('Z1','Estatus')
					->setCellValue('AA1','FecGeneracion');


		$fila = 2;
		while($row_principal = oci_fetch_row($stmt))
		{
			$cadena_ue="SELECT
							* 
						FROM
							(
							SELECT
								detalle.MODN_FOLIO,
								detalle.modc_tipomov,
								( SELECT PROC_CVEPROVEEDOR FROM cxp_proveedores WHERE TRIM( PROC_CVEPROVEEDOR ) = TRIM( movs.MOVC_CVEPROVEEDOR ) ) AS Proveedor,
								( SELECT PROC_NOMBRE FROM cxp_proveedores WHERE TRIM( PROC_CVEPROVEEDOR ) = TRIM( movs.MOVC_CVEPROVEEDOR ) ) AS NombreProveedor,
								TO_CHAR( movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD' ) AS FECHAMOV
							FROM
								INV_RENGLONES_MOVIMIENTOS detalle
								INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
								AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
								AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
							WHERE
								ARTC_ARTICULO = '$row_principal[2]' 
								AND movs.ALMN_ALMACEN = '$sucursal' 
								AND detalle.ALMN_ALMACEN = '$sucursal' 
								AND movs.MOVD_FECHAAFECTACION IS NOT NULL 
								AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' OR detalle.MODC_TIPOMOV = 'ETRANS' ) 
							ORDER BY
								movs.MOVD_FECHAAFECTACION DESC 
							) 
						WHERE
							ROWNUM <=1";
			$st = oci_parse($conexion_central, $cadena_ue);
			//oci_execute($st);
			//$row_ue = oci_fetch_row($st);

			$cadenaPromedio="SELECT IFNULL((SELECT ARTC_PROMEDIOUNIVENTA FROM ARTC_PROMEDIOVENTA WHERE ARTC_ARTICULO='$row_principal[2]'),0) AS ARTC_PROMEDIOVENTA, IFNULL((SELECT ARTC_PARTICIPACION FROM ARTC_PROMEDIOVENTA WHERE ARTC_ARTICULO='$row_principal[2]'),0) AS ARTC_PARTICIPACION";
			$consultaPromedio=mysqli_query($conexion,$cadenaPromedio);
			$rowPromedio=mysqli_fetch_row($consultaPromedio);
			

			$objPHPExcel->setActiveSheetIndex($i)
						->setCellValue('A'.$fila, $row_principal[0])
						->setCellValue('B'.$fila, $row_principal[1])
						->setCellValue('C'.$fila, "$row_principal[2]")
						->setCellValue('D'.$fila, $row_principal[3])
						->setCellValue('E'.$fila, $row_principal[10])
						->setCellValue('F'.$fila, $row_principal[4])
						->setCellValue('G'.$fila, $row_principal[5])
						->setCellValue('H'.$fila, $rowPromedio[0])
						->setCellValue('I'.$fila, $rowPromedio[1])
						->setCellValue('J'.$fila, $row_principal[10])
						->setCellValue('K'.$fila, $row_principal[9])
						//->setCellValue('L'.$fila, $row_principal[8])
						->setCellValue('M'.$fila, $row_principal[7])
						//->setCellValue('N'.$fila, $row_principal[8])
						->setCellValue('O'.$fila, $row_principal[8])
						->setCellValue('Y'.$fila, 'COMPRA')
						->setCellValue('Z'.$fila, 'ALTA')
						->setCellValue('AA'.$fila, $fecha);

			$activeSheet = $objPHPExcel->getActiveSheet();
			$formatoMoneda = '$#,##0.00';
			$activeSheet->getStyle('G'.$fila)->getNumberFormat()->setFormatCode($formatoMoneda);
			$activeSheet->getColumnDimension('A')->setAutoSize(true);
			$activeSheet->getColumnDimension('B')->setAutoSize(true);
			$activeSheet->getColumnDimension('C')->setAutoSize(true);
			$activeSheet->getColumnDimension('D')->setAutoSize(true);
			$activeSheet->getColumnDimension('E')->setAutoSize(true);
			$activeSheet->getColumnDimension('F')->setAutoSize(true);
			$activeSheet->getColumnDimension('G')->setAutoSize(true);
			$activeSheet->getColumnDimension('H')->setAutoSize(true);
			$activeSheet->getColumnDimension('I')->setAutoSize(true);
			$activeSheet->getColumnDimension('J')->setAutoSize(true);
			$activeSheet->getColumnDimension('K')->setAutoSize(true);
			$activeSheet->getColumnDimension('L')->setAutoSize(true);
			$activeSheet->getColumnDimension('M')->setAutoSize(true);
			$activeSheet->getColumnDimension('N')->setAutoSize(true);
			
			switch ($sucursal) {
				case 1:
					$nombreSuc= 'DIAZ ORDAZ';
					break;
				case 2:
					$nombreSuc= 'ARBOLEDAS';
					break;
				case 3:
					$nombreSuc= 'VILLEGAS';
					break;
				case 4:
					$nombreSuc= 'ALLENDE';
					break;
				case 5:
					$nombreSuc= 'PETACA';
					break;
				case 6:
					$nombreSuc= 'MONTEMORELOS';
					break;
				default:
					echo 'NA';
					break;
			}

			$objPHPExcel->getActiveSheet()->setTitle($nombreSuc);
			$fila = $fila + 1;
		}
		// Establecer formato de columna como texto
		$objPHPExcel->getActiveSheet()->getStyle("C:C")->getNumberFormat()->setFormatCode("@");

		// Recorrer cada celda de la columna C y establecer su valor como texto
		foreach ($objPHPExcel->getActiveSheet()->getRowIterator() as $fila) {
			$celda = $objPHPExcel->getActiveSheet()->getCell("C" . $fila->getRowIndex());
			$valor = $celda->getValue();
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("C" . $fila->getRowIndex(), $valor, PHPExcel_Cell_DataType::TYPE_STRING);
		}

		//Formato de moneda de una columna

		$i=$i+1;
	}
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="REP_ADM001_Desplazamiento'.date('Ymd').'.xlsx"');
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
	//$objWriter->save('\\\\200.1.1.178\\res_mis\\RPT001\\REP_ADM001_Desplazamiento'.date('Ymd').'.xlsx');
	exit;
?>
