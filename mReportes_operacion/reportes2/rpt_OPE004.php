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
$sucursal = $_POST['sucursal_OPE004'];
$familia = $_POST['familia_OPE004'];



$consulta_principal  = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
						    familias.FAMC_DESCRIPCION AS Familia,
                            (
                                SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE
                            ) AS Departamento,
						    (SELECT spin_articulos.fn_existencia_disponible_todos (
							13,
							NULL,
							NULL,
							1,
							1,
							$sucursal,
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual) AS Existencia,
                        ROUND(INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2)
						FROM
							INV_ARTICULOS_DETALLE
						INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
                        AND INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '$familia'
						ORDER BY
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO";
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
	            ->setCellValue('C1', 'Departamento')
	            ->setCellValue('D1', 'Familia')
	            ->setCellValue('E1', 'Costo Promedio')
	            ->setCellValue('F1', 'Ventas')
                ->setCellValue('G1', 'Existencias')
                ->setCellValue('H1', 'Excedente')
                ->setCellValue('I1', 'Valor excedente')
                ->setCellValue('J1', '% del valor del exc');


	$fila = 2;
	$suma_excedentes_total_do = 0;
	while($row_principal = oci_fetch_row($stmt))
	{

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row_principal[3])
	            ->setCellValue('D'.$fila, $row_principal[2])
	            ->setCellValue('E'.$fila, $row_principal[5]);
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
							AND TIK.TICC_SUCURSAL = '$sucursal'
							AND DETALLE.TICC_SUCURSAL = '$sucursal'
							AND TIK.TICN_ESTATUS = 3";
				$stat2 = oci_parse($conexion_central, $smermas);
				oci_execute($stat2);

				$row_merma = oci_fetch_row($stat2);
				$excedente = $row_principal[4] - $row_merma[0];
				if ($excedente < 0) {
					$excedente = 0;
				}else{
					$excedente = $excedente;
				}
				$valor_exce = $excedente * $row_principal[5];
				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('F'.$fila, $row_merma[0])
	            ->setCellValue('G'.$fila, $row_principal[4])
	            ->setCellValue('H'.$fila, $excedente)
	            ->setCellValue('I'.$fila, $valor_exce)
	            ->setCellValue('J'.$fila, "");

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

        $suma_excedentes_total_do = $suma_excedentes_total_do + $valor_exce;    
	$fila = $fila + 1;
	}

	oci_execute($stmt);
	$fila=2;
	while ($row_2 = oci_fetch_row($stmt)) {
		$objPHPExcel ->setActiveSheetIndex(0);
		$c_i = $objPHPExcel->getActiveSheet()->getCell('I' . $fila)->getCalculatedValue();

		$porc_valor_do = round($c_i / $suma_excedentes_total_do, 4) * 100;
		$objPHPExcel->setActiveSheetIndex(0)
        	->setCellValue('J'.$fila, $porc_valor_do . "%");

		$fila = $fila + 1;
	}

	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Excedentes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="excedentes_sucursal" '.$fecha.' ".xlsx"');
	header('Content-Disposition: attachment;filename="Excedentes_Sucursal_' .$fecha. '.xlsx"');

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
