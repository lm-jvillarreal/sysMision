<?php
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_final = $_POST['fecha_final'];
$fecha_fin=str_replace("-","",$fecha_final);
// $sucursal = $_POST['sucursal'];
// $familia = $_POST['familia'];
$f_inicio = new DateTime($fecha_inicio);
$f_fin = new DateTime($fecha_final);
$diff = $f_inicio->diff($f_fin);
$dias = $diff->days;
$dias = $dias +1;
$proveedor = $_POST['proveedor'];
$proveedor = trim($proveedor);
$array = $_POST['array'];
$arra = explode(',', $array);
$or="";
if ($proveedor == "") {
	$cantidad = count($arra);
	for ($i=1; $i < $cantidad; $i++) {
		$consulta = " OR INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
	$where = " WHERE (INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[0]'".$or.")";

	$consulta_principal  = "SELECT DISTINCT
						INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
						INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
						INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
						familias.FAMC_DESCRIPCION AS Familia,
						(SELECT PROC_CVEPROVEEDOR FROM COM_ARTICULOSLISTAPRECIOS WHERE INV_ARTICULOS_DETALLE.ARTC_ARTICULO = COM_ARTICULOSLISTAPRECIOS.ARTC_ARTICULO AND ROWNUM = 1),
						(SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
						(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '1', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia, 	
						(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '2', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Arboledas,
						(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '3', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Villegas,
						(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '4', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Allende,
						ROUND( INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2),
						(SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1),
						(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '5', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Petaca,
						(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '99', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS CEDIS
					FROM
						INV_ARTICULOS_DETALLE
					INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA".$where."
					ORDER BY INV_ARTICULOS_DETALLE.ARTC_ARTICULO";
}else{
		$consulta_principal = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
							INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
							familias.FAMC_DESCRIPCION AS Familia,
							LISTA.PROC_CVEPROVEEDOR,
							(SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE) AS Departamento,
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '1', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS Existencia,
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '2', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS Arboledas,
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '3', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS Villegas,
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '4', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS Allende,
							ROUND (INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2),
							(SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1),
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '5', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS Petaca,
							(SELECT spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, '99', INV_ARTICULOS_DETALLE.ARTC_ARTICULO) FROM dual) AS CEDIS
						FROM
							INV_ARTICULOS_DETALLE
						INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
						INNER JOIN COM_ARTICULOSLISTAPRECIOS LISTA ON LISTA.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						WHERE
							LISTA.PROC_CVEPROVEEDOR = '$proveedor'
						ORDER BY
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO";
}

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

	    function cellColor($cells,$color){
        global $objPHPExcel;
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill('')
        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => $color)
        ));
    }

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
	            ->setCellValue('E1', 'Ult. Costo')
							->setCellValue('F1', 'U. Emp.')
							->setCellValue('G1', 'Vtas. DO')
							->setCellValue('H1', 'Ptes. DO')
							->setCellValue('H1', 'Teo DO')
							->setCellValue('I1', 'Teo DO Cajas')
							->setCellValue('J1', 'Falt. DO')
							->setCellValue('K1', 'Falt. Caj. DO')
							->setCellValue('L1', 'Dias Inv. DO')
							->setCellValue('M1', 'Vtas. ARB')
							->setCellValue('N1', 'Teo. ARB')
							->setCellValue('O1', 'Teo. ARB Cajas')
							->setCellValue('P1', 'Faltante ARB')
							->setCellValue('Q1', 'Falt. Caj. ARB')
							->setCellValue('R1', 'Dias Inv. Arb')
							->setCellValue('S1', 'Vtas. VILL')
							->setCellValue('T1', 'Teo. VILL')
							->setCellValue('U1', 'Teo. VILL Cajas')
							->setCellValue('V1', 'Falt. VILL')
							->setCellValue('W1', 'Falt. Caj. VILL')
							->setCellValue('X1', 'Dias Inv. VILL')
							->setCellValue('Y1', 'Vtas. ALL')
							->setCellValue('Z1', 'Teo. ALL')
							->setCellValue('AA1', 'Teo. ALL Cajas')
							->setCellValue('AB1', 'Falt. ALL')
							->setCellValue('AC1', 'Falt. Caj. ALL')
							->setCellValue('AD1', 'Dias Inv. All')
							->setCellValue('AE1', 'Vtas. Petaca')
							->setCellValue('AF1', 'Teo. Petaca')
							->setCellValue('AG1', 'Teo. Petaca Cajas')
							->setCellValue('AH1', 'Falt. Petaca')
							->setCellValue('AI1', 'Falt. Caj. Petaca')
							->setCellValue('AJ1', 'Dias Inv. Petaca')
							->setCellValue('AK1', 'Teo Cedis');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$fila, $row_principal[0])
								->setCellValue('B'.$fila, $row_principal[1])
								->setCellValue('C'.$fila, $row_principal[5])
								->setCellValue('D'.$fila, $row_principal[3])
								->setCellValue('E'.$fila, $row_principal[2])
								->setCellValue('F'.$fila, $row_principal[11]);

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
		$faltante = $row_merma[0] - $row_principal[6]; //faltante = ventas - existencias
		if($faltante == 0 || $row_principal[11]==""){
			$fue_do = 0;
		}elseif($faltante<0){
			$faltante_ue=($faltante * -1)/$row_principal[11];
			$fue_do = ceil($faltante_ue);
            $fue_do = $fue_do * -1;
        }else{
            $faltante_ue=($faltante)/$row_principal[11];
            $fue_do = ceil($faltante_ue);
        }
		if (empty($row_merma[0])) {
			$dias_inventario = "";
		}else{
			$dias_inventario = $row_principal[6]/($row_merma[0]/$dias);//existencias/(ventas/dias)
            $dias_inventario = ROUND($dias_inventario);
		}

		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$fila, $row_merma[0])
								->setCellValue('H'.$fila, $row_principal[6])
								->setCellValue('J'.$fila, $faltante)
								->setCellValue('L'.$fila, $dias_inventario);

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
		$st_v_arb = oci_parse($conexion_central, $v_arb);
		oci_execute($st_v_arb);

		$row_v_arb = oci_fetch_row($st_v_arb);
		$faltante_arb = $row_v_arb[0] - $row_principal[7]; //faltante = ventas - existencias
		if($faltante_arb == 0 || $row_principal[11]==""){
			$fue_arb = 0;
		}elseif($faltante < 0){
			$faltante_ue=($faltante_arb * -1)/$row_principal[11];
			$fue_arb = ceil($faltante_ue);
            $fue_arb = $fue_arb * -1;
        }else{
            $faltante_ue=($faltante_arb)/$row_principal[11];
            $fue_arb = ceil($faltante_ue);
        }
		if (empty($row_v_arb[0])) {
			$dias_inventario_arb = "";
		}else{
			$dias_inventario_arb = $row_principal[7]/($row_v_arb[0]/$dias);//existencias/(ventas/dias)
            $dias_inventario_arb = ROUND($dias_inventario_arb);
		}

		$v_vill = "SELECT
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
		$st_v_vill = oci_parse($conexion_central, $v_vill);
		oci_execute($st_v_vill);

		$row_v_vill = oci_fetch_row($st_v_vill);
		$faltante_vill = $row_v_vill[0] - $row_principal[8]; //faltante = ventas - existencias
		if($faltante_vill == 0 || $row_principal[11]==""){
			$fue_vill = 0;
		}elseif($faltante < 0){
			$faltante_ue=($faltante_vill * -1)/$row_principal[11];
			$fue_vill = ceil($faltante_ue);
            $fue_vill = $fue_vill * -1;
        }else{
            $faltante_ue=($faltante_vill)/$row_principal[11];
            $fue_vill = ceil($faltante_ue);
        }
		if (empty($row_v_vill[0])) {
			$dias_inventario_vill = "";
		}else{
			$dias_inventario_vill = $row_principal[8]/($row_v_vill[0]/$dias);//existencias/(ventas/dias)
            $dias_inventario_vill = ROUND($dias_inventario_vill);
		}

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
		$st_v_all = oci_parse($conexion_central, $v_all);
		oci_execute($st_v_all);

		$row_v_all = oci_fetch_row($st_v_all);

		$faltante_all = $row_v_all[0] - $row_principal[9]; //faltante = ventas - existencias
		if($faltante_all == 0 || $row_principal[11]==""){
			$fue_all = 0;
		}elseif($faltante < 0){
			$faltante_ue=($faltante_all * -1)/$row_principal[11];
			$fue_all = ceil($faltante_ue);
            $fue_all = $fue_all * -1;
        }else{
            $faltante_ue=($faltante_all)/$row_principal[11];
            $fue_all = ceil($faltante_ue);
        }
		if (empty($row_v_all[0])) {
			$dias_inventario_all = "";
		}else{
			$dias_inventario_all = $row_principal[9]/($row_v_all[0]/$dias);//existencias/(ventas/dias)
            $dias_inventario_all = ROUND($dias_inventario_all);
		}


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
		$st_v_petaca = oci_parse($conexion_central, $v_petaca);
		oci_execute($st_v_petaca);
		$row_v_petaca = oci_fetch_row($st_v_petaca);

		$faltante_petaca = $row_v_petaca[0] - $row_principal[12]; //faltante = ventas - existencias
		if($faltante_petaca == 0 || $row_principal[11]==""){
			$fue_petaca = 0;
		}elseif($faltante < 0){
			$faltante_ue=($faltante_petaca * -1)/$row_principal[11];
			$fue_petaca = ceil($faltante_ue);
            $fue_petaca = $fue_all * -1;
        }else{
            $faltante_ue=($faltante_petaca)/$row_principal[11];
            $fue_petaca = ceil($faltante_ue);
        }
		if (empty($row_v_petaca[0])) {
			$dias_inventario_petaca = "";
		}else{
			$dias_inventario_petaca = $row_principal[12]/($row_v_petaca[0]/$dias);//existencias/(ventas/dias)
            $dias_inventario_petaca = ROUND($dias_inventario_petaca);
		}



		$teoDo = $row_principal[6];
		$teoArb = $row_principal[7];
		$teoVill = $row_principal[8];
		$teoAll = $row_principal[9];
		$teoPet = $row_principal[12];

		if($teoDo == 0 || $row_principal[11]==""){
			$tueDo = 0;
		}else{
			$tueDo  = $teoDo/$row_principal[11];
			$tueDo = round($tueDo,2);
		}
		if($teoArb == 0 || $row_principal[11]==""){
			$tueArb = 0;
		}else{
			$tueArb  = $teoArb/$row_principal[11];
			$tueArb = round($tueArb,2);
		}
		if($teoVill == 0 || $row_principal[11]==""){
			$tueVill = 0;
		}else{
			$tueVill  = $teoVill/$row_principal[11];
			$tueVill = round($tueVill,2);
		}
		if($teoAll == 0 || $row_principal[11]==""){
			$tueAll = 0;
		}else{
			$tueAll  = $teoAll/$row_principal[11];
			$tueAll = round($tueAll,2);
		}

		if($teoPet == 0 || $row_principal[11]==""){
			$tuePet = 0;
		}else{
			$tuePet  = $teoPet/$row_principal[11];
			$tuePet = round($tuePet,2);
		}

		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('I'.$fila, $tueDo)
								->setCellValue('K'.$fila, $fue_do)
								->setCellValue('M'.$fila, $row_v_arb[0])
								->setCellValue('N'.$fila, $row_principal[7])
								->setCellValue('O'.$fila, $tueArb)
								->setCellValue('P'.$fila, $faltante_arb)
								->setCellValue('Q'.$fila, $fue_arb)
								->setCellValue('R'.$fila, $dias_inventario_arb)
								->setCellValue('S'.$fila, $row_v_vill[0])
								->setCellValue('T'.$fila, $row_principal[8])
								->setCellValue('U'.$fila, $tueVill)
								->setCellValue('V'.$fila, $faltante_vill)
								->setCellValue('W'.$fila, $fue_vill)
								->setCellValue('X'.$fila, $dias_inventario_vill)
								->setCellValue('Y'.$fila, $row_v_all[0])
								->setCellValue('Z'.$fila, $row_principal[9])
								->setCellValue('AA'.$fila, $tueAll)
								->setCellValue('AB'.$fila, $faltante_all)
								->setCellValue('AC'.$fila, $fue_all)
								->setCellValue('AD'.$fila, $dias_inventario_all)
								->setCellValue('AE'.$fila, $row_v_petaca[0])
								->setCellValue('AF'.$fila, $row_principal[12])
								->setCellValue('AG'.$fila, $tuePet)
								->setCellValue('AH'.$fila, $faltante_petaca)
								->setCellValue('AI'.$fila, $fue_petaca)
								->setCellValue('AJ'.$fila, $dias_inventario_petaca)
								->setCellValue('AK'.$fila, $row_principal[13]);

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

	$fila = 2;
	oci_execute($stmt);
	while ($row_2 = oci_fetch_row($stmt)) {
		$objPHPExcel ->setActiveSheetIndex(0);
		$c_i = $objPHPExcel->getActiveSheet()->getCell('L' . $fila)->getCalculatedValue();
		$c_h = $objPHPExcel->getActiveSheet()->getCell('J' . $fila)->getCalculatedValue();
		$c_l = $objPHPExcel->getActiveSheet()->getCell('P' . $fila)->getCalculatedValue();
		$c_m = $objPHPExcel->getActiveSheet()->getCell('R' . $fila)->getCalculatedValue();
		$c_p = $objPHPExcel->getActiveSheet()->getCell('U' . $fila)->getCalculatedValue();
		$c_q = $objPHPExcel->getActiveSheet()->getCell('X' . $fila)->getCalculatedValue();
		$c_t = $objPHPExcel->getActiveSheet()->getCell('Z' . $fila)->getCalculatedValue();
		$c_u = $objPHPExcel->getActiveSheet()->getCell('AA' . $fila)->getCalculatedValue();
	
		if ($c_h > 0) {
			cellColor('L'.$fila, 'F28A8C');
		}
		if ($c_i < 10) {
			cellColor('M'.$fila, 'F28A8C');
		}
		if ($c_l > 0) {
			cellColor('R'.$fila, 'F28A8C');
		}
		if ($c_m < 10) {
			cellColor('S'.$fila, 'F28A8C');
		}
		if ($c_p > 0) {
			cellColor('Z'.$fila, 'F28A8C');
		}
		if ($c_q < 10) {
			cellColor('X'.$fila, 'F28A8C');
		}
		if ($c_t > 0) {
			cellColor('Z'.$fila, 'F28A8C');
		}
		if ($c_u < 10) {
			cellColor('AAB'.$fila, 'F28A8C');
		}
		$fila = $fila +1;
	}

	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Dias de inventario');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="rptDiasInv" '.$fecha.' ".xlsx"');
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
