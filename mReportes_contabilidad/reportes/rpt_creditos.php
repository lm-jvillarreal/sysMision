<?php 
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$sucursal = $_POST['sucursal'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$familia = $_POST['familia'];
$departamento = $_POST['departamento'];
$fecha_i=str_replace("-","",$fecha_inicial);
$fecha_f=str_replace("-","",$fecha_final);

if ($sucursal == 1) {
	$suc = "Diaz Ordaz";
}elseif ($sucursal == 2) {
	$suc = "Arboledas";
}elseif($sucursal == 3){
	$suc = "Villegas";
}else{
	$suc = "Allende";
}




$consulta_principal  = "SELECT
												PV_TICKETS.TICN_AAAAMMDDVENTA,
												PV_TICKETS.TICN_FOLIO,
												PV_TICKETS.TICC_CAJERO,
												TICC_CLIENTE,
												PV_TICKETS.TICN_VENTA,
												CFG_CLIENTES.CLIC_NOMBRE,
												CTB_USUARIO.USUC_NOMBRE,
												pv_tickets.ticn_ajuste AS AJUSTE, 
												(SELECT NVL(SUM(imtn_montoimpuesto),0) FROM pv_impticket WHERE ticn_aaaammddventa=PV_TICKETS.TICN_AAAAMMDDVENTA AND ticn_folio=PV_TICKETS.TICN_FOLIO AND TICC_SUCURSAL='$sucursal') AS IMPUESTO
											FROM
												PV_TICKETS
											INNER JOIN CXC_DOCUMENTOS ON CXC_DOCUMENTOS.CLIC_CLIENTE = PV_TICKETS.TICC_CLIENTE
											AND PV_TICKETS.TICN_REFERENCIACXC = CXC_DOCUMENTOS.DOCN_REFERENCIA
											INNER JOIN CFG_CLIENTES ON CFG_CLIENTES.CLIC_CLIENTE = PV_TICKETS.TICC_CLIENTE
											INNER JOIN CTB_USUARIO ON CTB_USUARIO.USUS_USUARIO = PV_TICKETS.TICC_CAJERO
											WHERE
												TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' AND '$fecha_f'
											AND TICC_SUCURSAL = '$sucursal'";
							// echo "$consulta_principal";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);


	// /** Error reporting */
	// //error_reporting(E_ALL);
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


	//Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Ticket')
	            ->setCellValue('B1', 'Folio')
	            ->setCellValue('C1', 'Cajero')
	            ->setCellValue('D1', 'Cliente')
	            ->setCellValue('E1', 'Total');


	$fila = 2;
	$total = 0;
	while($row_principal = oci_fetch_row($stmt))
	{
		$total_ticket = $row_principal[4]+$row_principal[8]+$row_principal[7];
		$total_ticket=round($total_ticket,2);
		$total = $total + $total_ticket;
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row_principal[6])
	            ->setCellValue('D'.$fila, $row_principal[5])
	            ->setCellValue('E'.$fila, $total_ticket);


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
	  $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, "Total")
	            ->setCellValue('E'.$fila, $total);

	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Creditos');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="rpt_creditos" '.$fecha.' ".xlsx"');
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
