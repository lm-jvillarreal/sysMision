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
							comc_descripcion,
							comc_receptor_nombre,
							comc_sucursal_infofin,
							comc_cfdi_serie,
							comc_cfdi_folio,
							comc_cfdi_uuid,
							comn_subtotal_mf,
							comn_monto_descuento_mf,
							comn_total_imp_trasladado_mf,
							comn_total_factura_mf,
							comd_creacion,
							comn_folio_serie,
							comc_receptor_rfc,
							COMC_LE_NOMBRE,
							COMC_CFDI_FOLIO,
							COMC_CFDI_SERIE,
						    COMN_IMPORTE_MB,
						    COMN_MONTO_IMP_MB,
						    COMC_CLIENTE,
						    COMN_ESTATUS_ENVIO_PAC_CAN
						FROM
							cfd_comprobantes
						WHERE
							comc_tipo_comprobante = 'F'
						AND COMD_CREACION >= TRUNC (
							TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')
						)
						AND COMD_CREACION < TRUNC (
							TO_DATE ('$fecha_final', 'YYYY/MM/DD')
						) + 1";

							//echo "$consulta_principal";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);





// 	/** Error reporting */
// 	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
	ini_set('display_errors', TRUE);
	ini_set('memory_limit', '256M');
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
	            ->setCellValue('A1', 'Fecha factura')
	            ->setCellValue('B1', '# cliente')
	            ->setCellValue('C1', 'Nombre Receptor')
	            ->setCellValue('D1', 'RFC Receptor')///////////
	            ->setCellValue('E1', 'Subtotal')
	            ->setCellValue('F1', 'Impuestos')
	            ->setCellValue('G1', 'Total')
	            ->setCellValue('H1', 'Serie')
                ->setCellValue('I1', 'Folio')
                ->setCellValue('J1', 'Sucursal Emisora')
                ->setCellValue('K1', 'UUDI')
                ->setCellValue('L1', 'Status');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$total_factura =  $row_principal[16] + $row_principal[17];
		if (is_null($row_principal[19])) {
			$stat = "Vigente";
		}elseif ($row_principal[19] == 1) {
			$stat = "Can INFOFIN";
		}elseif ($row_principal[19] == 2){
			$stat = "Can DIVERSA";
		}
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[10])
	            ->setCellValue('B'.$fila, $row_principal[18])
	            ->setCellValue('C'.$fila, $row_principal[1])
	            ->setCellValue('D'.$fila, $row_principal[12])
	            ->setCellValue('E'.$fila, $row_principal[16])
	            ->setCellValue('F'.$fila, $row_principal[17])
	            ->setCellValue('G'.$fila, $total_factura);
		
	            
		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H'.$fila, $row_principal[3])
                ->setCellValue('I'.$fila, $row_principal[4])
                ->setCellValue('J'.$fila, $row_principal[13])
                ->setCellValue('K'.$fila, $row_principal[5])
                ->setCellValue('L'.$fila, $stat);


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
	$objPHPExcel->getActiveSheet()->setTitle('Facturas de ingresos');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="rpt_facturas_ingresos" '.$fecha.' ".xlsx"');
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
