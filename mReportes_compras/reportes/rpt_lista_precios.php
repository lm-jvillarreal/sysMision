<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$proveedor = $_POST['proveedor'];
$p = trim($proveedor);

$consulta_principal  = "SELECT DISTINCT
							LIS.ARTC_ARTICULO,
							artic.ARTC_DESCRIPCION,
							LIS.PROC_CVEPROVEEDOR,
							prov.PROC_NOMBRE,
							LIS.LISN_LISTA,
							ROUND(LIS.ALPN_PRECIO, 2) AS costo,
							ROUND(artic.ARTN_PRECIOVENTA, 2),
							artic.ARTC_TIPOIMPUESTO1,
							artic.ARTC_TIPOIMPUESTO2,
							( SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familia.FAMC_FAMILIAPADRE ) AS departamento,
							familia.FAMC_DESCRIPCION AS familia,
							LIS.ALPN_PCT_DESCUENTO_0_100,
							LIS.ALPN_PCT_DESCUENTO2_0_100,
							LIS.ALPN_PCT_DESCUENTO3_0_100,
							LIS.ALPN_PCT_DESCUENTO4_0_100,
							LIS.ALPN_PCT_DESCUENTO5_0_100 
						FROM
							COM_ARTICULOSLISTAPRECIOS lis
							INNER JOIN PV_ARTICULOS artic ON artic.ARTC_ARTICULO = LIS.ARTC_ARTICULO
							INNER JOIN COM_FAMILIAS familia ON familia.FAMC_FAMILIA = artic.ARTC_FAMILIA
						INNER JOIN  CXP_PROVEEDORES prov ON trim(prov.PROC_CVEPROVEEDOR) = LIS.PROC_CVEPROVEEDOR 	
						WHERE
							lis.PROC_CVEPROVEEDOR = '$p'";
							//echo "$consulta_principal";

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
	            ->setCellValue('A1', 'No. Proveedor')
	            ->setCellValue('B1', 'Nombre Proveedor')
	            ->setCellValue('C1', 'Lista')
	            ->setCellValue('D1', 'Articulo')
	            ->setCellValue('E1', 'Descripcion')
	            ->setCellValue('F1', 'Costo')
                ->setCellValue('G1', 'IVA')
                ->setCellValue('H1', 'IEPS')
                ->setCellValue('I1', 'D1')
                ->setCellValue('J1', 'D2')
                ->setCellValue('K1', 'D3')
                ->setCellValue('L1', 'D4')
                ->setCellValue('M1', 'D5')
                ->setCellValue('N1', 'Departamento')
                ->setCellValue('O1', 'Familia')
                ->setCellValue('P1', 'Precio Venta')
                ->setCellValue('Q1', 'Margen');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{

			$margen = (1-($row_principal[5] / $row_principal[6]))*100;
			$rm = round($margen,2);
	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[2])
	            ->setCellValue('B'.$fila, $row_principal[3])	            
	            ->setCellValue('C'.$fila, $row_principal[4])
	            ->setCellValue('D'.$fila, $row_principal[0])
	            ->setCellValue('E'.$fila, $row_principal[1])
	            ->setCellValue('F'.$fila, $row_principal[5])
	            ->setCellValue('G'.$fila, $row_principal[7])
	            ->setCellValue('H'.$fila, $row_principal[8])
	            ->setCellValue('I'.$fila, $row_principal[11])
	            ->setCellValue('J'.$fila, $row_principal[12])
	            ->setCellValue('K'.$fila, $row_principal[13])
	            ->setCellValue('L'. $fila, $row_principal[14])
	            ->setCellValue('M'.$fila, $row_principal[15])
	            ->setCellValue('N'.$fila, $row_principal[9])
	            ->setCellValue('O'.$fila, $row_principal[10])
	            ->setCellValue('P'.$fila, $row_principal[6])
	            ->setCellValue('Q'.$fila, $rm."%");

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
	$objPHPExcel->getActiveSheet()->setTitle('lista_precios');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="lista_precios" '.$proveedor.' ".xlsx"');
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
