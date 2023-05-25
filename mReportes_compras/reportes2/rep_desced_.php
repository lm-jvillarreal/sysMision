<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');

$consulta_principal  = "SELECT
INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
familias.FAMC_DESCRIPCION AS Familia,
( SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
NVL( ( SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1 ), 0 ) AS U_EMP,
INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '99', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM DUAL ) AS EXITEO,
(
SELECT
  SUM( R.RMON_CANTSURTIDA ) 
FROM
  INV_RENGLONES_MOVIMIENTOS R
  INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO 
WHERE
  ( MOV.MODC_TIPOMOV = 'STRANS' ) 
  AND MOV.MOVD_FECHAAFECTACION >= trunc(
  TO_DATE( '2022-08-01', 'YYYY/MM/DD' )) 
  AND MOV.MOVD_FECHAAFECTACION < trunc(
  TO_DATE( '2022-08-31', 'YYYY/MM/DD' )) + 1 
  AND r.ALMN_ALMACEN = '99' 
  AND MOV.ALMN_ALMACEN = '99' 
  AND R.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
) AS CEDIS_STRANS
FROM
INV_ARTICULOS_DETALLE
INNER JOIN COM_ARTICULOSLISTAPRECIOS ON INV_ARTICULOS_DETALLE.ARTC_ARTICULO = COM_ARTICULOSLISTAPRECIOS.ARTC_ARTICULO
INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA 
WHERE
INV_ARTICULOS_DETALLE.ARTD_BAJA IS NULL 
AND COM_ARTICULOSLISTAPRECIOS.PROC_CVEPROVEEDOR = '4084'";
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
	header('Content-Disposition: attachment;filename="REPCOM_ExiSuc'.date('Ymd').'.xlsx"');
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
