<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$sucursal = $_POST['sucursal'];

$cadena_consulta  = "SELECT
DISTINCT(renglon.ARTC_ARTICULO),a.ARTC_DESCRIPCION,
(SELECT SUM(a.RMON_CANTSURTIDA) 
    FROM INV_RENGLONES_MOVIMIENTOS a 
    WHERE a.artc_articulo = renglon.artc_articulo 
    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'SALXVE' AND ALMN_ALMACEN = '$sucursal') AS CANTIDAD,
(SELECT spin_articulos.fn_existencia_disponible_todos(13, NULL, NULL, 1, 1, $sucursal, renglon.ARTC_ARTICULO)FROM dual) AS Existencia,
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
(SELECT SUM(a.RMON_CANTSURTIDA) 
    FROM INV_RENGLONES_MOVIMIENTOS a 
    WHERE a.artc_articulo = renglon.artc_articulo 
    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'ENTCOC' AND ALMN_ALMACEN = '$sucursal') AS ENTCOC,
(SELECT SUM(a.RMON_CANTSURTIDA) 
    FROM INV_RENGLONES_MOVIMIENTOS a 
    WHERE a.artc_articulo = renglon.artc_articulo 
    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'ENTSOC' AND ALMN_ALMACEN = '$sucursal') AS ENTSOC,
(SELECT SUM(a.RMON_CANTSURTIDA) 
    FROM INV_RENGLONES_MOVIMIENTOS a 
    WHERE a.artc_articulo = renglon.artc_articulo 
    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'ENTTRA' AND ALMN_ALMACEN = '$sucursal') AS ENTTRA,
(SELECT SUM(a.RMON_CANTSURTIDA) 
    FROM INV_RENGLONES_MOVIMIENTOS a 
    WHERE a.artc_articulo = renglon.artc_articulo 
    AND a.RMON_ESTATUS='2' AND a.MODC_TIPOMOV = 'ETRANS' AND ALMN_ALMACEN = '$sucursal') AS ETRANS
FROM  INV_RENGLONES_MOVIMIENTOS renglon 
INNER JOIN COM_ARTICULOS a  on a.artc_articulo = renglon.artc_articulo
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = a.ARTC_FAMILIA
WHERE renglon.RMON_ESTATUS = '2' AND renglon.MODC_TIPOMOV = 'SALXVE' AND renglon.ALMN_ALMACEN = '$sucursal'
ORDER BY renglon.ARTC_ARTICULO ASC";
							
							//echo "$cadena_consulta";
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
	            ->setCellValue('A1', 'Articulo')
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Cantidada afectar')
	            ->setCellValue('D1', 'Existencia')
	            ->setCellValue('E1', 'Faltante')
	            ->setCellValue('F1', 'ENTCOC')
	            ->setCellValue('G1', 'ENTSOC')
	            ->setCellValue('H1', 'ENTTRA')
	            ->setCellValue('I1', 'ETRANS')
	            ->setCellValue('J1', 'Departamento');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{

		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, ($row_principal[3]-$row_principal[2])*-1)
	            ->setCellValue('F'.$fila, $row_principal[5])
	            ->setCellValue('G'.$fila, $row_principal[6])
	            ->setCellValue('H'.$fila, $row_principal[7])
	            ->setCellValue('I'.$fila, $row_principal[8])
	            ->setCellValue('J'.$fila, $row_principal[4]);

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

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Estado de resultados" '.$fecha.' ".xlsx"');
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
