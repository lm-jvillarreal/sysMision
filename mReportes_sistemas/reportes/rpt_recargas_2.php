<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
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
// $sucursal = $_POST['sucursal'];
// $familia = $_POST['familia'];



$consulta_principal  = "SELECT
							ARTC_ARTICULO, ARTC_DESCRIPCION
						FROM
							COM_ARTICULOS 
						WHERE ARTC_ARTICULO BETWEEN '9000' AND '9043'
						AND ARTC_DESCRIPCION LIKE '%RECARGA%'
						AND ARTC_DESCRIPCION NOT LIKE '%TELCEL%'
						ORDER BY
							ARTC_ARTICULO";
						// echo "$consulta_principal";
						// echo "$fecha_fin";
						// echo "$fecha_i";

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
	            ->setCellValue('A1', 'Codigo')
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Ventas DO')
	            ->setCellValue('D1', 'Ventas Arb')
	            ->setCellValue('E1', 'Ventas Vill')
	            ->setCellValue('F1', 'Ventas All');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1]);


	            $smermas = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '1'
							AND DETALLE.TICC_SUCURSAL = '1'
							AND TIK.TICN_ESTATUS = 3";
				$stat2 = oci_parse($conexion_central, $smermas);
				oci_execute($stat2);
				$row_merma = oci_fetch_row($stat2);

	            $v_arb = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '2'
							AND DETALLE.TICC_SUCURSAL = '2'
							AND TIK.TICN_ESTATUS = 3";
				$stat_arb = oci_parse($conexion_central, $v_arb);
				oci_execute($stat_arb);
				$row_v_arb = oci_fetch_row($stat_arb);

            	$v_vil = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '3'
							AND DETALLE.TICC_SUCURSAL = '3'
							AND TIK.TICN_ESTATUS = 3";
				$stat3 = oci_parse($conexion_central, $v_vil);
				oci_execute($stat3);
				$row_v_vill = oci_fetch_row($stat3);

	            $v_all = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '4'
							AND DETALLE.TICC_SUCURSAL = '4'
							AND TIK.TICN_ESTATUS = 3";
				$stat4 = oci_parse($conexion_central, $v_all);
				oci_execute($stat4);
				$row_v_all = oci_fetch_row($stat4);

				$v_petaca = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '5'
							AND DETALLE.TICC_SUCURSAL = '5'
							AND TIK.TICN_ESTATUS = 3";
				$stat_petaca = oci_parse($conexion_central, $v_petaca);
				oci_execute($stat_petaca);
				$row_v_pet = oci_fetch_row($stat_petaca);

				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('C'.$fila, $row_merma[0])
	            ->setCellValue('D'.$fila, $row_v_arb[0])
	            ->setCellValue('E'.$fila, $row_v_vill[0])
	            ->setCellValue('F'.$fila, $row_v_all[0]);

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
	$objPHPExcel->getActiveSheet()->setTitle('DIESTEL');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="rpt_diestel" '.$fecha.' ".xlsx"');
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
