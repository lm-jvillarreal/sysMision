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
							->setCellValue('H1', 'Pendientes DO')
							->setCellValue('I1', 'Teo DO')
							->setCellValue('J1', 'Teo DO Cajas')
							->setCellValue('K1', 'Falt. DO')
							->setCellValue('L1', 'Falt. Caj. DO')
							->setCellValue('M1', 'Dias Inv. DO')
							->setCellValue('N1', 'Vtas. ARB')
							->setCellValue('O1', 'Pendientes ARB')
							->setCellValue('P1', 'Teo. ARB')
							->setCellValue('Q1', 'Teo. ARB Cajas')
							->setCellValue('R1', 'Falt. ARB')
							->setCellValue('S1', 'Falt. Caj. ARB')
							->setCellValue('T1', 'Dias Inv. Arb')
							->setCellValue('U1', 'Vtas. VILL')
							->setCellValue('V1', 'Pendientes VILL')
							->setCellValue('W1', 'Teo. VILL')
							->setCellValue('X1', 'Teo. VILL Cajas')
							->setCellValue('Y1', 'Falt. VILL')
							->setCellValue('Z1', 'Falt. Caj. VILL')
							->setCellValue('AA1', 'Dias Inv. VILL')
							->setCellValue('AB1', 'Vtas. ALL')
							->setCellValue('AC1', 'Pendientes ALL')
							->setCellValue('AD1', 'Teo. ALL')
							->setCellValue('AE1', 'Teo. ALL Cajas')
							->setCellValue('AF1', 'Falt. ALL')
							->setCellValue('AG1', 'Falt. Caj. ALL')
							->setCellValue('AH1', 'Dias Inv. All')
							->setCellValue('AI1', 'Vtas. Petaca')
							->setCellValue('AJ1', 'Pendientes Petaca')
							->setCellValue('AK1', 'Teo. Petaca')
							->setCellValue('AL1', 'Teo. Petaca Cajas')
							->setCellValue('AM1', 'Falt. Petaca')
							->setCellValue('AN1', 'Falt. Caj. Petaca')
							->setCellValue('AO1', 'Dias Inv. Petaca')
							->setCellValue('AP1', 'Teo Cedis');

	function dev_venta($cadena_conexion,$almn_almacen,$artc_articulo,$fecha_a, $fecha_b){
		$qry_devolucion_venta = "SELECT NVL(SUM(DETALLE.ARTN_CANTIDAD),'0')
															FROM
																	PV_ARTICULOSTICKET detalle
															INNER JOIN PV_TICKETS tik ON CONCAT(TIK.TICN_AAAAMMDDVENTA,TIK.TICN_FOLIO) = CONCAT(DETALLE.TICN_AAAAMMDDVENTA,DETALLE.TICN_FOLIO)
															AND tik.TICC_SUCURSAL=detalle.ticc_sucursal
															WHERE
																	DETALLE.ARTC_ARTICULO = '$artc_articulo'
															AND TIK.ticn_aaaammddventa BETWEEN '$fecha_a'
															AND '$fecha_b'
															AND (
																	TIK.TICN_ESTATUS = 2
																	OR TIK.TICN_ESTATUS = 3
															)
															AND tik.TICC_SUCURSAL = '$almn_almacen'
															AND DETALLE.TICC_SUCURSAL = '$almn_almacen'
															AND tik.ticn_tipomov='-1'";
		$st_dev_venta = oci_parse($cadena_conexion, $qry_devolucion_venta);
		oci_execute($st_dev_venta);
		$row_dev_venta = oci_fetch_row($st_dev_venta);

		$devolucion_venta=$row_dev_venta[0];
		return $devolucion_venta;
	}
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
								AND TIK.TICN_ESTATUS = 3
								AND (tik.ticn_tipomov='1' OR tik.ticn_tipomov='9')";

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
		//$dev_do=dev_venta($conexion_central,'1',$row_principal[0],$fecha_i,$fecha_fin);
		//$dev_arb=dev_venta($conexion_central,'2',$row_principal[0],$fecha_i,$fecha_fin);
		//$dev_vill=dev_venta($conexion_central,'3',$row_principal[0],$fecha_i,$fecha_fin);
		//$dev_all=dev_venta($conexion_central,'4',$row_principal[0],$fecha_i,$fecha_fin);
		//$dev_pet=dev_venta($conexion_central,'5',$row_principal[0],$fecha_i,$fecha_fin);

		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$fila, $row_merma[0])
								->setCellValue('I'.$fila, $row_principal[6])
								->setCellValue('K'.$fila, $faltante)
								->setCellValue('M'.$fila, $dias_inventario);

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
							AND TIK.TICN_ESTATUS = 3
							AND (tik.ticn_tipomov='1' OR tik.ticn_tipomov='9')";
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
								AND TIK.TICN_ESTATUS = 3
								AND (tik.ticn_tipomov='1' OR tik.ticn_tipomov='9')";
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
							AND TIK.TICN_ESTATUS = 3
							AND (tik.ticn_tipomov='1' OR tik.ticn_tipomov='9')";
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
								AND TIK.TICN_ESTATUS = 3
								AND (tik.ticn_tipomov='1' OR tik.ticn_tipomov='9')";
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
		//MOVIMIENTOS PENDIENTES
		$cadenaPendientesDO="SELECT NVL(sum(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
												INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
												and m.modc_tipomov = rm.modc_tipomov 
												AND m.modn_folio = rm.modn_folio 
												WHERE  (m.modc_tipomov = 'SIROTA' OR m.modc_tipomov='SALXVE')
												AND rm.artc_articulo = '$row_principal[0]'
												AND m.movn_estatus = '2'
												AND m.ALMN_ALMACEN = '1'
												AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$fecha_inicio', 'YYYY/MM/DD')) 
												AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD')) +1";
		$st_pendientesDO=oci_parse($conexion_central,$cadenaPendientesDO);
		oci_execute($st_pendientesDO);
		$row_PendientesDO = oci_fetch_row($st_pendientesDO);

		$cadenaPendientesARB="SELECT NVL(sum(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
												INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
												and m.modc_tipomov = rm.modc_tipomov 
												AND m.modn_folio = rm.modn_folio
												WHERE  m.modc_tipomov='SALXVE'
												AND rm.artc_articulo = '$row_principal[0]'
												AND m.movn_estatus = '2'
												AND m.ALMN_ALMACEN = '2'
												AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$fecha_inicio', 'YYYY/MM/DD')) 
												AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD')) +1";
		$st_pendientesARB=oci_parse($conexion_central,$cadenaPendientesARB);
		oci_execute($st_pendientesARB);
		$row_PendientesARB = oci_fetch_row($st_pendientesARB);

		$cadenaPendientesVILL="SELECT NVL(sum(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
												INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
												and m.modc_tipomov = rm.modc_tipomov 
												AND m.modn_folio = rm.modn_folio
												WHERE  m.modc_tipomov='SALXVE'
												AND rm.artc_articulo = '$row_principal[0]'
												AND m.movn_estatus = '2'
												AND m.ALMN_ALMACEN = '3'
												AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$fecha_inicio', 'YYYY/MM/DD')) 
												AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD')) +1";
		$st_pendientesVILL=oci_parse($conexion_central,$cadenaPendientesVILL);
		oci_execute($st_pendientesVILL);
		$row_PendientesVILL = oci_fetch_row($st_pendientesVILL);

		$cadenaPendientesALL="SELECT NVL(sum(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
												INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
												and m.modc_tipomov = rm.modc_tipomov
												AND m.modn_folio = rm.modn_folio
												WHERE  m.modc_tipomov='SALXVE'
												AND rm.artc_articulo = '$row_principal[0]'
												AND m.movn_estatus = '2'
												AND m.ALMN_ALMACEN = '4'
												AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$fecha_inicio', 'YYYY/MM/DD')) 
												AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD')) +1";
		$st_pendientesALL=oci_parse($conexion_central,$cadenaPendientesALL);
		oci_execute($st_pendientesALL);
		$row_PendientesALL = oci_fetch_row($st_pendientesALL);

		$cadenaPendientesPET="SELECT NVL(sum(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
												INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
												and m.modc_tipomov = rm.modc_tipomov 
												AND m.modn_folio = rm.modn_folio
												WHERE  m.modc_tipomov='SALXVE'
												AND rm.artc_articulo = '$row_principal[0]'
												AND m.movn_estatus = '2'
												AND m.ALMN_ALMACEN = '5'
												AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$fecha_inicio', 'YYYY/MM/DD')) 
												AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD')) +1";
		$st_pendientesPET=oci_parse($conexion_central,$cadenaPendientesPET);
		oci_execute($st_pendientesPET);
		$row_PendientesPET = oci_fetch_row($st_pendientesPET);
		//
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('H'.$fila, $row_PendientesDO[0])
								->setCellValue('J'.$fila, $tueDo)
								->setCellValue('L'.$fila, $fue_do)
								->setCellValue('N'.$fila, $row_v_arb[0])
								->setCellValue('O'.$fila, $row_PendientesARB[0])
								->setCellValue('P'.$fila, $row_principal[7])
								->setCellValue('Q'.$fila, $tueArb)
								->setCellValue('R'.$fila, $faltante_arb)
								->setCellValue('S'.$fila, $fue_arb)
								->setCellValue('T'.$fila, $dias_inventario_arb)
								->setCellValue('U'.$fila, $row_v_vill[0])
								->setCellValue('V'.$fila, $row_PendientesVILL[0])
								->setCellValue('W'.$fila, $row_principal[8])
								->setCellValue('X'.$fila, $tueVill)
								->setCellValue('Y'.$fila, $faltante_vill)
								->setCellValue('Z'.$fila, $fue_vill)
								->setCellValue('AA'.$fila, $dias_inventario_vill)
								->setCellValue('AB'.$fila, $row_v_all[0])
								->setCellValue('AC'.$fila, $row_PendientesALL[0])
								->setCellValue('AD'.$fila, $row_principal[9])
								->setCellValue('AE'.$fila, $tueAll)
								->setCellValue('AF'.$fila, $faltante_all)
								->setCellValue('AG'.$fila, $fue_all)
								->setCellValue('AH'.$fila, $dias_inventario_all)
								->setCellValue('AI'.$fila, $row_v_petaca[0])
								->setCellValue('AJ'.$fila, $row_PendientesPET[0])
								->setCellValue('AK'.$fila, $row_principal[12])
								->setCellValue('AL'.$fila, $tuePet)
								->setCellValue('AM'.$fila, $faltante_petaca)
								->setCellValue('AN'.$fila, $fue_petaca)
								->setCellValue('AO'.$fila, $dias_inventario_petaca)
								->setCellValue('AP'.$fila, $row_principal[13]);

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
		$c_k = $objPHPExcel->getActiveSheet()->getCell('K' . $fila)->getCalculatedValue();
		$c_m = $objPHPExcel->getActiveSheet()->getCell('M' . $fila)->getCalculatedValue();
		$c_l = $objPHPExcel->getActiveSheet()->getCell('R' . $fila)->getCalculatedValue();
		$c_m = $objPHPExcel->getActiveSheet()->getCell('T' . $fila)->getCalculatedValue();
		$c_p = $objPHPExcel->getActiveSheet()->getCell('Y' . $fila)->getCalculatedValue();
		$c_q = $objPHPExcel->getActiveSheet()->getCell('AA' . $fila)->getCalculatedValue();
		$c_t = $objPHPExcel->getActiveSheet()->getCell('AF' . $fila)->getCalculatedValue();
		$c_u = $objPHPExcel->getActiveSheet()->getCell('AH' . $fila)->getCalculatedValue();
		$C_AL= $objPHPExcel->getActiveSheet()->getCell('AM' . $fila)->getCalculatedValue();
		$C_AN= $objPHPExcel->getActiveSheet()->getCell('AO' . $fila)->getCalculatedValue();
	
		if ($c_k > 0) {
			cellColor('K'.$fila, 'F28A8C');
		}
		if ($c_m < 10) {
			cellColor('M'.$fila, 'F28A8C');
		}
		if ($c_l > 0) {
			cellColor('R'.$fila, 'F28A8C');
		}
		if ($c_m < 10) {
			cellColor('T'.$fila, 'F28A8C');
		}
		if ($c_p > 0) {
			cellColor('Y'.$fila, 'F28A8C');
		}
		if ($c_q < 10) {
			cellColor('AA'.$fila, 'F28A8C');
		}
		if ($c_t > 0) {
			cellColor('AF'.$fila, 'F28A8C');
		}
		if ($c_u < 10) {
			cellColor('AH'.$fila, 'F28A8C');
		}
		if($C_AL>0){
			cellColor('AM'.$fila, 'F28A8C');
		}
		if($C_AN<10){
			cellColor('AO'.$fila, 'F28A8C');
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
