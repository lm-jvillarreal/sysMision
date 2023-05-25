<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$familia = $_POST['familia_OPE003'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_fin=str_replace("-","",$fecha_final);



$consulta_principal  = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
							INV_ARTICULOS_DETALLE.ARTN_PRECIO_ULTIMA_COMPRA,
							INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA,
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
							1,
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual) AS ExistenciaDiazOrdaz,
                        (SELECT spin_articulos.fn_existencia_disponible_todos (
							13,
							NULL,
							NULL,
							1,
							1,
							2,
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual) AS ExistenciasArboledas,
                        (SELECT spin_articulos.fn_existencia_disponible_todos (
							13,
							NULL,
							NULL,
							1,
							1,
							3,
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual) AS ExistenciasVillegas,
                        (SELECT spin_articulos.fn_existencia_disponible_todos (
							13,
							NULL,
							NULL,
							1,
							1,
							4,
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual)AS ExistenciasAllende,
                        
                        ROUND(INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO,2)
						FROM
							INV_ARTICULOS_DETALLE
						INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
                        --AND familias.FAMC_FAMILIAPADRE = '02'
                        --AND (INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '751' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '244' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '200' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '209')
                        AND INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '$familia'
						ORDER BY
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
                            ";

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
	            ->setCellValue('F1', 'Ventas DO')
                ->setCellValue('G1', 'Existencias DO')
                ->setCellValue('H1', 'Excedente DO')
                ->setCellValue('I1', 'Valor excedente DO')
                ->setCellValue('J1', '% del valor del exc DO')
                ->setCellValue('K1', 'Ventas Arb')
                ->setCellValue('L1', 'Existencias Arb')
                ->setCellValue('M1', 'Excedente Arb')
                ->setCellValue('N1', 'Valor Excedente Arb')
                ->setCellValue('O1', '% del valor exc Arb')
                ->setCellValue('P1', 'Ventas Vill')
                ->setCellValue('Q1', 'Existencias Vill')
                ->setCellValue('R1', 'Excedente Vill')
                ->setCellValue('S1', 'Valor Excedente Vill')
                ->setCellValue('T1', '% del valor exc Vill')
                ->setCellValue('U1', 'Ventas All')
                ->setCellValue('V1', 'Existencias All')
                ->setCellValue('W1', 'Excedente All')
                ->setCellValue('X1', 'Valor excedente All')
                ->setCellValue('Y1', '% del valor exc All')
                ->setCellValue('Z1', 'Ventas totales')
                ->setCellValue('AA1', 'Exis Totales')
                ->setCellValue('AB1', 'Exced Total')
                ->setCellValue('AC1', 'Valor Exc')
                ->setCellValue('AD1', '% valor Exc')
                ->setCellValue('AE1', 'Suma de exc')
                ->setCellValue('AF1', 'Valor de suma de exc')
                ->setCellValue('AG1', '% de valor de sum de exc')
                ->setCellValue('AH1', 'Exced Iguales');


	$fila = 2;
	$porc_valor_do              = 0;
	$porc_valor_arb             = 0;
	$porc_valor_vill            = 0;
	$porc_valor_all             = 0;
	$porc_val_sum_exc           = 0;
	$por_valor_total_exc        = 0;
	$suma_excedentes_total_do   = 0;
	$suma_excedentes_total_arb  = 0;
	$suma_excedentes_total_vill = 0;
	$suma_excedentes_total_all  = 0;
	$suma_c_af                  = 0;
	$suma_c_ac                  = 0;
	while($row_principal = oci_fetch_row($stmt))
	{

	
		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row_principal[5])
	            ->setCellValue('D'.$fila, $row_principal[4])
	            ->setCellValue('E'.$fila, $row_principal[10]);
	            

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
				$excedenteDO = $row_principal[6]- $row_merma[0];
				if ($excedenteDO  < 0) {
					$excedenteDO = 0;
				}else{
					$excedenteDO = $excedenteDO;
				}
				$valor_ex_do = $excedenteDO * $row_principal[10];
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('F'.$fila, $row_merma[0])
                ->setCellValue('G'.$fila, $row_principal[6])
                ->setCellValue('H'.$fila, $excedenteDO);

	            $ventas_arb = "SELECT
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
				$stat_arb = oci_parse($conexion_central, $ventas_arb);
				oci_execute($stat_arb);
				$row_varb = oci_fetch_row($stat_arb);
				$excedenteAr = $row_principal[7]-$row_varb[0];
				if ($excedenteAr < 0) {
					$excedenteAr = 0;
				}else{
					$excedenteAr = $excedenteAr;
				}
				$valor_ex_arb = $excedenteAr * $row_principal[10];
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('I'.$fila, $valor_ex_do)
                ->setCellValue('J'.$fila, "")
                ->setCellValue('K'.$fila, $row_varb[0])
                ->setCellValue('L'.$fila, $row_principal[7])
                ->setCellValue('M'.$fila, $excedenteAr)
                ->setCellValue('N'.$fila, $valor_ex_arb)
                ->setCellValue('O'.$fila, "");
	            $ventas_vil = "SELECT
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
				$stat_vil = oci_parse($conexion_central, $ventas_vil);
				oci_execute($stat_vil);
				$row_vvil = oci_fetch_row($stat_vil);
				$excedenteVill = $row_principal[8]-$row_vvil[0];
				if ($excedenteVill < 0) {
						$excedenteVill = 0;
					}else{
						$excedenteVill = $excedenteVill;
					}
				$valor_ex_vill = $excedenteVill * $row_principal[10];
		$objPHPExcel->setActiveSheetIndex(0)	
                ->setCellValue('P'.$fila, $row_vvil[0])
                ->setCellValue('Q'.$fila, $row_principal[8])
                ->setCellValue('R'.$fila, $excedenteVill)
                ->setCellValue('S'.$fila, $valor_ex_vill)
                ->setCellValue('T'.$fila, "");

	            $ventas_all = "SELECT
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
				$stat_all = oci_parse($conexion_central, $ventas_all);
				oci_execute($stat_all);
				$row_all = oci_fetch_row($stat_all);
				$excedenteAll = $row_principal[9] - $row_all[0];
				if ($excedenteAll < 0) {
				   $excedenteAll = 0;		
              	}else{
              		$excedenteAll = $excedenteAll;
              	}
              	$valor_ex_all = $excedenteAll * $row_principal[10];
              	$ventas_totales = $row_all[0] + $row_merma[0] + $row_varb[0] + $row_vvil[0];
              	$exis_total = $row_principal[6] +$row_principal[7] + $row_principal[8] + $row_principal[9];
              	$excedente_total = $exis_total - $ventas_totales;
              	$excedente_total_suma = $excedenteAll + $excedenteAr + $excedenteDO + $excedenteVill;
              	if ($excedente_total < 0 ) {
              	   	$excedente_total = 0;
              	   }else{
              	   		$excedente_total = $excedente_total;
              	   }
              	   $valor_exc_total = $excedente_total * $row_principal[10];
              	   $valor_exc_total_suma = $excedente_total_suma * $row_principal[10];   
        $objPHPExcel->setActiveSheetIndex(0)
        	->setCellValue('U'.$fila, $row_all[0])
            ->setCellValue('V'.$fila, $row_principal[9])
            ->setCellValue('W'.$fila, $excedenteAll)
            ->setCellValue('X'.$fila, $valor_ex_all)
            ->setCellValue('Y'.$fila, "")
            ->setCellValue('Z'.$fila, $ventas_totales)
            ->setCellValue('AA'.$fila, $exis_total)
            ->setCellValue('AB'.$fila, $excedente_total)
            ->setCellValue('AC'.$fila, $valor_exc_total)
            ->setCellValue('AD'.$fila, "")
            ->setCellValue('AE'.$fila, $excedente_total_suma)
            ->setCellValue('AF'.$fila, $valor_exc_total_suma)
            ->setCellValue('AG'.$fila, "");




        		
        		

		



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

        $suma_excedentes_total_do = $suma_excedentes_total_do + $valor_ex_do;
        $suma_excedentes_total_arb = $suma_excedentes_total_arb + $valor_ex_arb;
        $suma_excedentes_total_vill = $suma_excedentes_total_vill + $valor_ex_vill;
        $suma_excedentes_total_all = $suma_excedentes_total_all + $valor_ex_all;
        $suma_c_af = $suma_c_af + $valor_exc_total_suma;
        $suma_c_ac = $suma_c_ac + $valor_exc_total;
	$fila = $fila + 1;
	}

	$fila = 2;
	oci_execute($stmt);
	while ($row_2 = oci_fetch_row($stmt)) {
		$objPHPExcel ->setActiveSheetIndex(0);
		$c_i = $objPHPExcel->getActiveSheet()->getCell('I' . $fila)->getCalculatedValue();
		$c_n = $objPHPExcel->getActiveSheet()->getCell('N' . $fila)->getCalculatedValue();
		$c_s = $objPHPExcel->getActiveSheet()->getCell('S' . $fila)->getCalculatedValue();
		$c_x = $objPHPExcel->getActiveSheet()->getCell('X' . $fila)->getCalculatedValue();
		$c_af = $objPHPExcel->getActiveSheet()->getCell('AF' . $fila)->getCalculatedValue() ;
		$c_ac = $objPHPExcel->getActiveSheet()->getCell('AC' . $fila)->getCalculatedValue();

		if ($c_af == $c_ac) {
			$value = "SI";
		}else{
			$value= "NO";
		}


		if($c_n == 0 || $suma_excedentes_total_do == 0){
			$porc_valor_arb = 0;
		}else{
			$porc_valor_do = round($c_n / $suma_excedentes_total_do, 4) * 100;
		} 

		if($c_n == 0 || $suma_excedentes_total_arb == 0){
			$porc_valor_arb = 0;
		}else{
			$porc_valor_arb = round($c_n / $suma_excedentes_total_arb, 4) * 100;
		}

		if($c_s == 0 || $suma_excedentes_total_vill == 0){
			$porc_valor_vill = 0;
		}else{
			$porc_valor_vill = round($c_s / $suma_excedentes_total_vill, 4) * 100;
		}

		if($c_x == 0 || $suma_excedentes_total_all == 0){
			$porc_valor_all = 0;
		}else{
			$porc_valor_all = round($c_x / $suma_excedentes_total_all, 4) * 100;
		}

		$porc_val_sum_exc = round($c_af/$suma_c_af, 4)*100;
		$por_valor_total_exc = round($c_ac / $suma_c_ac, 4)*100;

		$objPHPExcel->setActiveSheetIndex(0)
        	->setCellValue('J'.$fila, $porc_valor_do . "%")
        	->setCellValue('O'.$fila, $porc_valor_arb . "%")
        	->setCellValue('T'.$fila, $porc_valor_vill . "%")
        	->setCellValue('Y'.$fila, $porc_valor_all . "%")
        	->setCellValue('AD'.$fila, $porc_val_sum_exc . "%")
        	->setCellValue('AG'.$fila, $por_valor_total_exc. "%")
        	->setCellValue('AH'. $fila, $value);

		$fila = $fila +1;

	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Excedentes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="excedentes" '.$fecha.' ".xlsx"');
	header('Content-Disposition: attachment;filename="Reporte_Excedentes_' .$fecha. '.xlsx"');
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