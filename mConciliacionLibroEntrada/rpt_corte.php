<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_seguridad/verificar_sesion.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

$fecha=date('Y-m-d');
//Descargamos, creamos e inicializamos las variables de uso Local
$cadena_consulta  = "SELECT 
                    r.ficha_entrada,
                    r.cve_proveedor,
                    r.proveedor, 
                    r.remision, 
                    r.total_remision, 
                    r.total_entrada, 
                    r.total_devoluciones, 
                    r.total_cf, 
                    r.total_dc, 
                    r.gran_total, 
                    r.diferencia,
                    u.nombre_usuario 
                    FROM alb_resumenEntradas as r INNER JOIN usuarios as u ON r.usuario = u.id  where DATE_FORMAT(r.fecha,'%Y-%m-%d')='$fecha' AND r.usuario='$id_usuario'
                    order by CONVERT(r.ficha_entrada,UNSIGNED INTEGER) ASC";
							
							//echo "$cadena_consulta";
$consulta_principal = mysqli_query($conexion,$cadena_consulta);

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
	$objPHPExcel->getProperties()->setCreator("SysMision")
								 ->setLastModifiedBy("SysMision")
								 ->setTitle("Corte de Conciliación")
								 ->setSubject("Reporte de Sistemas")
								 ->setDescription("Reporte de Sistemas")
								 ->setKeywords("SysMision  Conciliacion Sistemas")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'F.E.')
	            ->setCellValue('B1', 'Cve.')
	            ->setCellValue('C1', 'proveedor')
	            ->setCellValue('D1', 'Remisión')
	            ->setCellValue('E1', 'Remisión($)')
	            ->setCellValue('F1', 'Entrada($)')
              ->setCellValue('G1', 'Devolución($)')
              ->setCellValue('H1', 'C.F.($)')
              ->setCellValue('I1', 'D.C.($)')
              ->setCellValue('J1', 'G.Total')
              ->setCellValue('K1', 'Dif')
              ->setCellValue('L1', 'Concilia');


	$fila = 2;
	while($row_principal = mysqli_fetch_array($consulta_principal))
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
              ->setCellValue('L'.$fila, $row_principal[11]);



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

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Conciliación');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="CorteConciliación.xlsx"');
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
