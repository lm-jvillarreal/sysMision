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



$consulta_principal  = "SELECT DISTINCT(ban_solpag.soli_numch),
												TO_CHAR(ctb_polizas_cheques.PCHD_FECHA,'YYYY/MM/DD') FECHA,
												(SELECT CHEQUES.POLC_INDICE AS POLIZA FROM ctb_polizas_cheques CHEQUES WHERE cheques.pchc_numero=ban_solpag.soli_numch AND ROWNUM=1) POLIZA,
												ctb_polizas_cheques.PCHC_RFC RFC,
												RTRIM(ctb_polizas_cheques.pchc_benef) PROVEEDOR, 
												ctb_polizas_cheques.pchn_monto,
												ban_solpag.soln_estatus
												FROM ban_solpag INNER JOIN CTB_POLIZAS_CHEQUES ON ban_solpag.soli_numch = ctb_polizas_cheques.pchc_numero AND ban_solpag.benc_rfc=ctb_polizas_cheques.pchc_rfc
												WHERE sold_fecch >= TRUNC (TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
												AND sold_fecch < TRUNC (TO_DATE ('$fecha_final', 'YYYY/MM/DD')) + 1
												GROUP BY ban_solpag.soli_numch,
													ctb_polizas_cheques.PCHD_FECHA,
													ctb_polizas_cheques.PCHC_RFC, 
													RTRIM(ctb_polizas_cheques.pchc_benef), 
													ctb_polizas_cheques.pchn_monto, 
													ban_solpag.soln_estatus
												ORDER BY soli_numch ASC";

							

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

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Analisis")
								 ->setDescription("Reporte de analisis")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	//Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Proveedor')
	            ->setCellValue('B1', 'RFC')
	            ->setCellValue('C1', 'Poliza')
	            ->setCellValue('D1', '# Cheque')
	            ->setCellValue('E1', 'Monto')
	            ->setCellValue('F1', 'Fecha')
	            ->setCellValue('G1', 'UUID del comprobante')
	            ->setCellValue('H1', 'UUID del complemento');


 	$fila = 2;
 	while($row_principal = oci_fetch_row($stmt))
 	{
 		
 		$fiscal = "SELECT D_D.DOCC_UUID_CFDI 
 					FROM CTB_POLIZAS_DOCTOS CPD 
					INNER JOIN CFG_DOCUMENTOS_DIGITALES D_D ON CPD.DOCN_ID = D_D.DOCN_ID 
					WHERE POLC_INDICE = '$row_principal[2]' 
					AND d_d.docn_monto IS NOT NULL
					AND D_D.DOCC_UUID_CFDI IS NOT NULL";
		$st_fiscal = oci_parse($conexion_central, $fiscal);
		oci_execute($st_fiscal);
		$row_fiscal = oci_fetch_row($st_fiscal);
		$fiscal2 = "SELECT D_D.DOCC_UUID_CFDI 
					FROM CTB_POLIZAS_DOCTOS CPD 
					INNER JOIN CFG_DOCUMENTOS_DIGITALES D_D ON CPD.DOCN_ID = D_D.DOCN_ID 
					WHERE POLC_INDICE = '$row_principal[2]' 
					AND d_d.docn_monto IS NULL
					AND D_D.DOCC_UUID_CFDI IS NOT NULL";
		$st_fiscal2 = oci_parse($conexion_central, $fiscal2);
		oci_execute($st_fiscal2);
		$row_fiscal2 = oci_fetch_row($st_fiscal2);

		if($row_principal[6]=='5'){
			$desc_cheque = ' ** CANCELADO ** '.$row_principal[4];
			$monto = '0';
		}else{
			$desc_cheque = $row_principal[4];
			$monto = $row_principal[5];
		}

		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $desc_cheque)
	            ->setCellValue('B'.$fila, $row_principal[3])	            
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[0])
	            ->setCellValue('E'.$fila, $monto)
	            ->setCellValue('F'. $fila, $row_principal[1])
	            ->setCellValue('G'.$fila, $row_fiscal[0])
	            ->setCellValue('H'. $fila, $row_fiscal2[0]);


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
	$objPHPExcel->getActiveSheet()->setTitle('Polizas_cheques');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Polizas_cheques" '.$fecha.' ".xlsx"');
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
