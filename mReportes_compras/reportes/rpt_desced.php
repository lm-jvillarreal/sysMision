<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fechareporte=date("Ymd");

$fechaInicial = $_POST['fecha_inicial'];
$fechaFinal = $_POST['fecha_final'];
$proveedor = $_POST['proveedor'];
$factor  = $_POST['factor_aumento'];
$factor = $factor/100;

$datetime1 = date_create($fechaInicial);
$datetime2 = date_create($fechaFinal);
$diferenciaDias = date_diff($datetime1, $datetime2);
$differenceFormat = '%a';
$diferenciaDias->format($differenceFormat);

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
  TO_DATE( '$fechaInicial', 'YYYY/MM/DD' )) 
  AND MOV.MOVD_FECHAAFECTACION < trunc(
  TO_DATE( '$fechaFinal', 'YYYY/MM/DD' )) + 1 
  AND r.ALMN_ALMACEN = '99' 
  AND MOV.ALMN_ALMACEN = '99' 
  AND R.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
) AS CEDIS_STRANS,
COM_ARTICULOSLISTAPRECIOS.LISN_LISTA
FROM
INV_ARTICULOS_DETALLE
INNER JOIN COM_ARTICULOSLISTAPRECIOS ON INV_ARTICULOS_DETALLE.ARTC_ARTICULO = COM_ARTICULOSLISTAPRECIOS.ARTC_ARTICULO
INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA 
WHERE
INV_ARTICULOS_DETALLE.ARTD_BAJA IS NULL 
AND COM_ARTICULOSLISTAPRECIOS.PROC_CVEPROVEEDOR = '$proveedor'";
							//echo $consulta_principal;

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
								 ->setTitle("Reporte de Desplazamiento")
								 ->setSubject("Compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'ARTICULO')
	            ->setCellValue('B1', 'DESCRIPCION')
							->setCellValue('C1', 'NLISTA')
	            ->setCellValue('D1', 'FAMILIA')
	            ->setCellValue('E1', 'DEPARTAMENTO')
	            ->setCellValue('F1', 'U.E.')
	            ->setCellValue('G1', 'ULT. COMP. $')
              ->setCellValue('H1', 'STRANS')
              ->setCellValue('I1', 'PROM. STRANS')
              ->setCellValue('J1', 'INV.SUG.')
              ->setCellValue('K1', 'CEDIS')
              ->setCellValue('L1', 'P.SUG. U.')
              ->setCellValue('M1', 'P.SUG. UE.')
              ->setCellValue('N1', 'P.SUG. $');

	$fila = 2;

	while($row_principal = oci_fetch_row($stmt))
	{
    $strans="";
    $promStrans="";
    
    if($row_principal[7]==null || $row_principal[7]==""){
      $strans=0;
      $promStrans=0;
    }else{
      $strans=$row_principal[7];
      $promStrans=$row_principal[7]/$diferenciaDias->format($differenceFormat);
      $promStrans=round($promStrans,2);
    }

    $inv_sugerido = $strans*$factor;
    $inv_sugerido = $inv_sugerido+$strans;
    $ped_sugerido = $inv_sugerido-$row_principal[6];

    if($row_principal[4]=="0"){
      $ped_sugerido_ue=0;
      //$ped_sugerido_monto=0;
    }else{
      $ped_sugerido_ue = $ped_sugerido/$row_principal[4];
    }
		$ped_sugerido_monto = $ped_sugerido*$row_principal[5];
		$ped_sugerido_monto=round($ped_sugerido_monto,2);
    
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])
							->setCellValue('C'.$fila, $row_principal[8])
	            ->setCellValue('D'.$fila, $row_principal[2])
	            ->setCellValue('E'.$fila, $row_principal[3])
	            ->setCellValue('F'.$fila, round($row_principal[4],3))
	            ->setCellValue('G'.$fila, $row_principal[5])
	            ->setCellValue('H'.$fila, $strans)
	            ->setCellValue('I'.$fila, $promStrans)
	            ->setCellValue('J'.$fila, ceil($inv_sugerido))
	            ->setCellValue('K'.$fila, $row_principal[6])
	            ->setCellValue('L'.$fila, ceil($ped_sugerido))
              ->setCellValue('M'.$fila, ceil($ped_sugerido_ue))
              ->setCellValue('N'.$fila, $ped_sugerido_monto);

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
	$objPHPExcel->getActiveSheet()->setTitle('Desplazamiento');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="REPCOM_DesCedPro_'.$fechareporte.'.xlsx"');
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
