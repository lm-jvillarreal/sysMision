<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');

$consulta_principal  = "SELECT 
                            (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
                            FAM.FAMC_DESCRIPCION,
                            COM_ARTICULOS.ARTC_ARTICULO, 
                            COM_ARTICULOS.ARTC_DESCRIPCION,
                            (
                            SELECT 
                                spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, COM_ARTICULOS.ARTC_ARTICULO)
                            FROM 
                                dual
                            ) DO,
                            (SELECT 
                                        
                                        spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, COM_ARTICULOS.ARTC_ARTICULO)
                                    FROM 
                                        dual) ARB,
                            (SELECT 
                                        spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, COM_ARTICULOS.ARTC_ARTICULO)
                                        
                                    FROM 
                                        dual) VILL,
                            (SELECT 
                                        spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, COM_ARTICULOS.ARTC_ARTICULO)
                                    FROM 
                                        dual) ALLE,
                            (SELECT 
                                        spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, COM_ARTICULOS.ARTC_ARTICULO)
                                    FROM 
                                        dual) PET,
                            (SELECT 
                                        spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, COM_ARTICULOS.ARTC_ARTICULO)
                                    FROM 
                                        dual) CEDIS,
                            TO_CHAR(COM_ARTICULOS.ARTD_ALTA,'DD/MM/YYYY')
                            FROM COM_ARTICULOS
                            INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
                            WHERE com_articulos.artn_estatus='2'";
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
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte de Existencias")
								 ->setSubject("Compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'DEPARTAMENTO')
	            ->setCellValue('B1', 'FAMILIA')
	            ->setCellValue('C1', 'ARTICULO')
	            ->setCellValue('D1', 'DESCRIPCION')
	            ->setCellValue('E1', 'DO')
	            ->setCellValue('F1', 'ARB')
                ->setCellValue('G1', 'VILL')
                ->setCellValue('H1', 'ALL')
                ->setCellValue('I1', 'PET')
                ->setCellValue('J1', 'CEDIS')
                ->setCellValue('K1', 'FECHA ALTA');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
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
	            ->setCellValue('K'.$fila, $row_principal[10]);

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
	$objPHPExcel->getActiveSheet()->setTitle('Existencias');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="REPCOM_ExiSuc_ARTBAJ'.date('Ymd').'.xlsx"');
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
