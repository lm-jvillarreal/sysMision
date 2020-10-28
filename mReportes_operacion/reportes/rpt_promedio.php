<?php 
error_reporting(E_ALL ^ E_NOTICE);
include '../../global_settings/conexion_oracle.php';
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
// $proveedor = $_POST['proveedor'];
// $p = trim($proveedor);
$proveedor = "";
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_f=str_replace("-","",$fecha_final);






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
	            ->setCellValue('A1', 'Sucursal')
	            ->setCellValue('B1', '# de tickets')
	            ->setCellValue('C1', 'Total de ventas')
	            ->setCellValue('D1', 'Promedio por ticket');


	$fila = 2;
	$i = 1;
	while($i <= 5)
	{

		$consulta_principal  = "SELECT
									COUNT (*),
									SUM (ROUND(TICN_VENTA, 2)),
									ROUND (AVG(TICN_VENTA), 2)
								FROM
									PV_TICKETS
								WHERE
									TICN_AAAAMMDDVENTA BETWEEN '$fecha_i'
								AND '$fecha_f'
								AND TICN_ESTATUS = '3'
								AND TICC_SUCURSAL = '$i'";

		$stmt = oci_parse($conexion_central, $consulta_principal);
		oci_execute($stmt);
		$row = oci_fetch_row($stmt);
		if ($i == 1) {
			$sucursal = "Diaz Ordaz";
		}elseif ($i == 2) {
			$sucursal = "Arboledas";
		}elseif($i == 3){
			$sucursal = "Villegas";
		}elseif($i == 4){
			$sucursal = "Allende";
		}elseif($i == 5){
			$sucursal = "Petaca";
		}
	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $sucursal)
	            ->setCellValue('B'.$fila, $row[0])	            
	            ->setCellValue('C'.$fila, $row[1])
	            ->setCellValue('D'.$fila, $row[2]);

	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

		$objPHPExcel->getActiveSheet()
    		->getColumnDimension('D')
    		->setAutoSize(false);
  
	$fila = $fila + 1;
	$i++;
	}



	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Promedio de ventas');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Promedio de ventas" '.$proveedor.' ".xlsx"');
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
