<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_seguridad/verificar_sesion.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_solicitud = $_GET['id'];

$cadena_consulta  = "SELECT codigo, descripcion, cantidad FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud' AND cantidad > 0";
							
$consulta_detalle = mysqli_query($conexion, $cadena_consulta);

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
	require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
              ->setLastModifiedBy("La Misión Supermercados")
              ->setTitle("Importador de etiquetas")
              ->setSubject("Solicitud de etiquetas")
              ->setDescription("Solicitud de etiquetas")
              ->setKeywords("office PHPExcel php")
              ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Código')
	            ->setCellValue('B1', 'Descripción')
              ->setCellValue('C1', 'Cantidad');


	$fila = 2;
	while($row_principal = mysqli_fetch_array($consulta_detalle))
	{

		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$fila, $row_principal[0])
                ->setCellValue('B'.$fila, $row_principal[1])
                ->setCellValue('C'.$fila, $row_principal[2]);



    $objPHPExcel->getActiveSheet()
                ->getColumnDimension('A')
                ->setAutoSize(true);

    $objPHPExcel->getActiveSheet()
                ->getColumnDimension('B')
                ->setAutoSize(true);
    
    $objPHPExcel->getActiveSheet()
                ->getColumnDimension('C')
                ->setAutoSize(true);

	  $fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de etiquetas');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Detalle de etiquetas" '.$fecha.' ".xlsx"');
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
