<?php 
error_reporting(E_ALL ^ E_NOTICE);
include '../../global_settings/conexion_oracle.php';
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_i=str_replace("-","",$fecha_inicio);
//$fecha_i=trim($fecha_inicio, "-");
$fecha_final = $_POST['fecha_final'];
//$fecha_fin=trim($fecha_final, "-");
$fecha_fin=str_replace("-","",$fecha_final);
$sucursal = $_POST['sucursal'];
//$familia = $_POST['familia'];
$concepto = $_POST['concepto'];



$consulta_principal  = "SELECT DISTINCT
							P_T.TICC_CAJERO,
							A_T.ARTC_ARTICULO,
							SUM (A_T.ARTN_CANTIDAD),
							ROUND (
								SUM (A_T.ARTN_PRECIOVENTA)
							,2),
							C_U.USUC_NOMBRE
						FROM
							PV_TICKETS P_T
						INNER JOIN PV_ARTICULOSTICKET A_T ON A_T.TICN_AAAAMMDDVENTA = P_T.TICN_AAAAMMDDVENTA
						AND P_T.TICN_FOLIO = A_T.TICN_FOLIO
						AND A_T.TICC_SUCURSAL = P_T.TICC_SUCURSAL
						INNER JOIN CFG_USUARIOS C_U ON C_U.USUN_ID = P_T.TICC_CAJERO
						WHERE
							P_T.TICC_SUCURSAL = '$sucursal'
						AND A_T.ARTC_ARTICULO = '$concepto'
						AND P_T.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i'
						AND '$fecha_fin'
						AND P_T.TICN_ESTATUS = '3'
						GROUP BY
							P_T.TICC_CAJERO,
							A_T.ARTC_ARTICULO,
							C_U.USUC_NOMBRE
						ORDER BY
							P_T.TICC_CAJERO";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);


	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
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
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Analisis")
								 ->setDescription("Reporte de analisis")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Cajero')
	            ->setCellValue('B1', 'Nombre')
	            ->setCellValue('C1', 'Cantidad')
	            ->setCellValue('D1', 'Importe redondeos');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[4])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3]);

	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

    	// $objPHPExcel->getActiveSheet()
    	// 	->getColumnDimension('D')
    	// 	->setAutoSize(true);

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
  
	$fila = $fila + 1;
	}


	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Recargas');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="redondeos" '.$fecha.' ".xlsx"');
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
