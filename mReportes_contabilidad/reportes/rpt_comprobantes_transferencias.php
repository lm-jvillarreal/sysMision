<?php 
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$folio = $_POST['folio'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];



$consulta_principal  = "SELECT
												TRANSFERENCIAS.POLC_INDICE,
												TO_CHAR (
													TRANSFERENCIAS.PTRD_FECHA,
													'YYYY/MM/DD'
												),
												TRANSFERENCIAS.PTRN_MONTO AS MONTO,
												TRANSFERENCIAS.PTRC_RFC AS RFC,
												TRIM (TRANSFERENCIAS.POLC_INDICE) AS POLIZA,
												TRIM(TRANSFERENCIAS.PTRC_BENEF),
												(SELECT soli_numch FROM ban_solpag WHERE solc_indice=TRANSFERENCIAS.polc_indice)
											FROM
												CTB_POLIZAS_TRANFERENCIAS TRANSFERENCIAS
											WHERE
												TRANSFERENCIAS.PTRD_FECHA >= TRUNC (
													TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')
												)
											AND TRANSFERENCIAS.PTRD_FECHA < TRUNC (
												TO_DATE ('$fecha_final', 'YYYY/MM/DD')
											) + 1";

							//echo "$consulta_principal";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);





// 	/** Error reporting */
// 	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	ini_set('memory_limit', '1024M');
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
	            ->setCellValue('A1', 'Indice de poliza')
	            ->setCellValue('B1', 'Fecha')
	            ->setCellValue('C1', 'Monto')
	            ->setCellValue('D1', 'RFC')
	            ->setCellValue('E1', 'Beneficiario')
	            ->setCellValue('F1', 'UUID del comprobante')
	            ->setCellValue('G1', 'UUID del complemento')
							->setCellValue('H1', 'Transferencia');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$fiscal = " SELECT D_D.DOCC_UUID_CFDI 
					FROM CTB_POLIZAS_DOCTOS CPD 
					INNER JOIN CFG_DOCUMENTOS_DIGITALES D_D ON CPD.DOCN_ID = D_D.DOCN_ID 
					WHERE POLC_INDICE = '$row_principal[4]' 
					AND d_d.docn_monto IS NOT NULL
					AND D_D.DOCC_UUID_CFDI IS NOT NULL";
		$st_fiscal = oci_parse($conexion_central, $fiscal);
		oci_execute($st_fiscal);
		$row_fiscal = oci_fetch_row($st_fiscal);
		$fiscal2 = "SELECT D_D.DOCC_UUID_CFDI 
					FROM CTB_POLIZAS_DOCTOS CPD 
					INNER JOIN CFG_DOCUMENTOS_DIGITALES D_D ON CPD.DOCN_ID = D_D.DOCN_ID 
					WHERE POLC_INDICE = '$row_principal[4]' 
					AND d_d.docn_monto IS NULL
					AND D_D.DOCC_UUID_CFDI IS NOT NULL";
		$st_fiscal2 = oci_parse($conexion_central, $fiscal2);
		oci_execute($st_fiscal2);
		$row_fiscal2 = oci_fetch_row($st_fiscal2);
		 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$fila, $row_principal[0])
								->setCellValue('B'.$fila, $row_principal[1])	            
								->setCellValue('C'.$fila, $row_principal[2])
								->setCellValue('D'.$fila, $row_principal[3])
								->setCellValue('E'.$fila, $row_principal[5])
								->setCellValue('F'.$fila, $row_fiscal[0])
								->setCellValue('G'. $fila, $row_fiscal2[0])
								->setCellValue('H'.$fila, $row_principal[6]);


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
	$objPHPExcel->getActiveSheet()->setTitle('Polizas_transferencias');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Polizas_transferencias" '.$fecha.' ".xlsx"');
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
