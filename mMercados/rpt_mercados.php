<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$folio_inicial = $_POST['folio_desde'];
$folio_final = $_POST['folio_hasta'];



$cadena_consulta  = "SELECT
renglon.modn_folio, renglon.ARTC_ARTICULO, a.ARTC_DESCRIPCION, renglon.RMON_CANTSURTIDA AS CANTIDAD,
(SELECT spin_articulos.fn_existencia_disponible_todos(13, NULL, NULL, 1, 1, 1, renglon.ARTC_ARTICULO)FROM dual) AS Existencia,
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
FAM.FAMC_DESCRIPCION As  Familia
FROM  INV_RENGLONES_MOVIMIENTOS renglon 
INNER JOIN COM_ARTICULOS a  on a.artc_articulo = renglon.artc_articulo
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = a.ARTC_FAMILIA
WHERE  renglon.MODC_TIPOMOV = 'SIROTA' AND renglon.ALMN_ALMACEN = '1' AND (renglon.MODN_FOLIO >= $folio_inicial AND renglon.modn_folio <= $folio_final)
ORDER BY renglon.MODN_FOLIO ASC";
$consulta_principal = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_principal);

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
								 ->setTitle("Reporte detalle de compras")
								 ->setSubject("Reporte de compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Folio')
	            ->setCellValue('B1', 'Codigo')
	            ->setCellValue('C1', 'Descripcion')
	            ->setCellValue('D1', 'Cantidad')
	            ->setCellValue('E1', 'Existencia')
	            ->setCellValue('F1', 'Departamento')
                ->setCellValue('G1', 'Familia');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
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
                ->setCellValue('G'.$fila, $row_principal[6]);



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

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Faltante de Mercados');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Mercados_"'.$fecha.'".xlsx"');
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
