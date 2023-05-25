<?php
//Incluimos la conexión a la BD de InfoFIN
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio =  str_replace("-","",$_POST['fecha_inicial']);
$fecha_fin = str_replace("-","",$_POST['fecha_final']);
$sucursal = $_POST['sucursal_ERD001'];
$fecha_ini = $_POST['fecha_inicial'];
$fecha_fn = $_POST['fecha_final'];

$cadena_consulta  = "
SELECT
	(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM = 1 ) AS Departamento,
	FAM.FAMC_DESCRIPCION,
	COM_ARTICULOS.ARTC_ARTICULO,
	COM_ARTICULOS.ARTC_DESCRIPCION,
	COM_ARTICULOS.ARTN_PRECIOVENTA,
	COM_ARTICULOS.ARTN_PRECIO_ULTIMA_COMPRA,
	(
SELECT
	SUM( a.ARTN_CANTIDAD_TOTAL) 
FROM
	pv_vta_diaria_articulo a 
WHERE
	a.artc_articulo = com_articulos.artc_articulo 
	AND ticn_aaaammddventa BETWEEN '$fecha_inicio' 
	AND '$fecha_fin' 
	AND TICC_SUCURSAL = 1 
	) AS U_Vendidas,
	(
SELECT
	SUM(a.ARTN_VENTA_TOTAL) 
FROM
	pv_vta_diaria_articulo a 
WHERE
	a.artc_articulo = com_articulos.artc_articulo 
	AND ticn_aaaammddventa BETWEEN '$fecha_inicio' 
	AND '$fecha_fin' 
	AND TICC_SUCURSAL = $sucursal
	) AS cantidad,
	(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, COM_ARTICULOS.ARTC_ARTICULO ) FROM dual ) AS Existencia,
	(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXROB'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))
		) AS SXROB,
			(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXMBOD'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))

		) AS SXMBOD,
					(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXMCAR'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))

		) AS SXMCAR,
							(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXMFCI'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))

		) AS SXMFCI,
							(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXMFTA'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))

		) AS SXMFTA,
							(		SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
		FROM INV_MOVIMIENTOS 
		INNER JOIN INV_RENGLONES_MOVIMIENTOS ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
		AND INV_MOVIMIENTOS.MODC_TIPOMOV = 'SXMPAN'
		AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
		AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  >= trunc(TO_DATE ('$fecha_ini', 'YYYY/MM/DD'))
		AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION  <= trunc(TO_DATE ('$fecha_fn', 'YYYY/MM/DD'))

		) AS SXMPAN
		
FROM
	COM_ARTICULOS
	INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA 
WHERE
	COM_ARTICULOS.ARTN_ESTATUS = 1 
	AND (
SELECT
	SUM( a.ARTN_CANTIDAD_TOTAL ) 
FROM
	pv_vta_diaria_articulo a 
WHERE
	a.artc_articulo = com_articulos.artc_articulo 
	AND ticn_aaaammddventa BETWEEN '$fecha_inicio' 
	AND '$fecha_fin' 
	AND TICC_SUCURSAL = $sucursal
	) IS NOT NULL 
ORDER BY
	fam.famc_descripcion ASC";
							
							//echo "$cadena_consulta";
$consulta_principal = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_principal);

// 	/** Error reporting */
// 	error_reporting(E_ALL);
	ini_set('max_execution_time', 500); 
	//ini_set('max_execution_time', 300); 
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	//* Include PHPExcel 
	require_once '../../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte detalle de compras")
								 ->setSubject("Reporte de compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Departamento')
	            ->setCellValue('B1', 'Familia')
	            ->setCellValue('C1', 'Clave Articulo')
	            ->setCellValue('D1', 'Descripcion Articulo')
	            ->setCellValue('E1', 'P. de venta')
	            ->setCellValue('F1', 'P. de Compra')
							->setCellValue('G1', 'U. vendidas')
							->setCellValue('H1', 'Cantidad')
							->setCellValue('I1', 'Existencia')
							->setCellValue('J1', 'SXROB')
							->setCellValue('K1', 'SXMBOD')
							->setCellValue('L1', 'SXMCAR')
							->setCellValue('M1', 'SXMFCI')
							->setCellValue('N1', 'SXMFTA')
							->setCellValue('O1', 'SXMPAN');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{
		$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, $row_principal[4])
	            ->setCellValue('F'.$fila, $row_principal[5])
							->setCellValue('G'.$fila, $row_principal[6])
							->setCellValue('H'.$fila, $row_principal[7])
							->setCellValue('I'.$fila, $row_principal[8])
							->setCellValue('J'.$fila, $row_principal[9])
							->setCellValue('K'.$fila, $row_principal[10])
							->setCellValue('L'.$fila, $row_principal[11])
							->setCellValue('M'.$fila, $row_principal[12])
							->setCellValue('N'.$fila, $row_principal[13])
							->setCellValue('O'.$fila, $row_principal[14]);



         $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('D')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('E')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('F')
    		->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('G')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('H')
				->setAutoSize(true);
			
			$objPHPExcel->getActiveSheet()
				->getColumnDimension('I')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('J')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('K')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('L')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('M')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('N')
				->setAutoSize(true);

			$objPHPExcel->getActiveSheet()
				->getColumnDimension('O')
				->setAutoSize(true);

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="EDR_'.$fecha_inicio.'-'.$fecha_fin.'.xlsx"');
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
