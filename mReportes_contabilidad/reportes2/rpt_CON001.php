<?php 
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$proveedor = $_POST['proveedor_CON001'];
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
if($proveedor==""){
	$filprov="";
}else{
	$filprov=" AND cuentas.PROC_CVEPROVEEDOR='$proveedor'";
}


$consulta_principal  = "SELECT DISTINCT
							cuentas.CXPC_INDICEPOL,
							(
								SELECT
									COMP.PCOC_UUDI_CFDI
								FROM
									ctb_polizas_comprobantes COMP
								WHERE
									POLC_INDICE = cuentas.CXPC_INDICEPOL
								AND ROWNUM = 1
							),
							cuentas.PROC_CVEPROVEEDOR,
							cuentas.CXPC_NUMFACT,
							cuentas.CXPD_FECHACONTAB,
							cuentas.CXPN_IMPORTE,
							cuentas.CXPN_IVA,
						    cuentas.cxpn_ieps,
							cuentas.CXPN_TOTPAGADO,
						    CXP_PROVEEDORES.PROC_NOMBRE,
    						CXP_PROVEEDORES.PROC_RFC
						FROM
							CXP_CXP cuentas
						INNER JOIN CXP_PROVEEDORES ON CXP_PROVEEDORES.PROC_CVEPROVEEDOR = cuentas.PROC_CVEPROVEEDOR
						WHERE
							CXPD_FECHACONTAB >= TRUNC (
								TO_DATE ('$fecha_inicio', 'YYYY/MM/DD')
							)
						AND CXPD_FECHACONTAB < TRUNC (
							TO_DATE ('$fecha_final', 'YYYY/MM/DD')
						) + 1
						$filprov
						ORDER BY
							cuentas.CXPC_NUMFACT";
							//
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
	            ->setCellValue('B1', 'UUDI')
	            ->setCellValue('C1', '# Proveedor')
	            ->setCellValue('D1', 'Nombre proveedor')
	            ->setCellValue('E1', 'RFC proveedor')
	            ->setCellValue('F1', 'Factura')
	            ->setCellValue('G1', 'Fecha entrada')
	            ->setCellValue('H1', 'Subtotal Factura')
	            ->setCellValue('I1', 'IVA')
	            ->setCellValue('J1', 'IEPS')
                ->setCellValue('K1', 'Total Factura')
                ->setCellValue('L1', 'Total notas credito')
                ->setCellValue('M1', 'Pagado/por pagar')
                ->setCellValue('N1', '# de cheque')
                ->setCellValue('O1', 'Fecha de pago');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0]);
	            $sel = "SELECT 
						    docs.PROC_CVEPROVEEDOR, 
						    docs.CXPC_NUMFACT, 
						    docs.DOCD_FECHAPAGO, 
						    docs.DOCN_NUMCHEQUE, 
						    (SELECT SUM(DOCN_IMPORTE)+ SUM(DOCN_IVA)+ SUM(DOCN_IEPS)  FROM CXP_DOCUMENTOS WHERE CXPC_NUMFACT = '$row_principal[3]' AND PROC_CVEPROVEEDOR = '$row_principal[2]' AND DOCN_TIPOPAGO = 3) AS nc 
						FROM CXP_DOCUMENTOS docs 
						WHERE docs.CXPC_NUMFACT = '$row_principal[3]' 
						AND docs.PROC_CVEPROVEEDOR = '$row_principal[2]' 
						AND docs.DOCN_TIPOPAGO = 0";
							
				$stat = oci_parse($conexion_central ,$sel);
				oci_execute($stat);
				$row = oci_fetch_row($stat);

			$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[9])
	            ->setCellValue('E'.$fila, $row_principal[10])
	            ->setCellValue('F'.$fila, $row_principal[3]);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('G'.$fila, $row_principal[4])
	            ->setCellValue('H'.$fila, $row_principal[5])
	            ->setCellValue('I'.$fila, $row_principal[6]);
	            $total_factura = $row_principal[5] + $row_principal[6] + $row_principal[7];
			$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('J'.$fila, $row_principal[7])
                ->setCellValue('K'.$fila, $total_factura)
                ->setCellValue('L'.$fila, $row[4])
                ->setCellValue('M'.$fila, $total_factura - $row[4])
                ->setCellValue('N'.$fila, $row[3])
                ->setCellValue('O'.$fila, $row[2]);


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
	header('Content-Disposition: attachment;filename="Polizas_cheques_'.$fecha.'.xlsx"');
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
