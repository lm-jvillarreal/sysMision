<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha_inicio = $_GET['fi'];
$fecha_fin = $_GET['ff'];
$sucursal = $_GET['suc'];
$now = new DateTime();

$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMCAR'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmcar = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmcar);
    while($row_sxmcar = oci_fetch_array($consulta_sxmcar)){
        $cantidad_sxmcar = oci_num_rows($consulta_sxmcar);
        $f_sxmcar = new DateTime($row_sxmcar[4]);
	}
	if($cantidad_sxmcar==0){
		$interval_sxmcar="No existen registros";
	}else{
		$interval_sxmcar = $f_sxmcar->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMFTA'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmfta = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmfta);
    while($row_sxmfta = oci_fetch_array($consulta_sxmfta)){
        $cantidad_sxmfta = oci_num_rows($consulta_sxmfta);
        $f_sxmfta = new DateTime($row_sxmfta[4]);
	}
	if($cantidad_sxmfta==0){
		$interval_sxmfta="No existen registros";
	}else{
		$interval_sxmfta = $f_sxmfta->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMPAN'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmpan = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmpan);
    while($row_sxmpan = oci_fetch_array($consulta_sxmpan)){
        $cantidad_sxmpan = oci_num_rows($consulta_sxmpan);
        $f_sxmpan = new DateTime($row_sxmpan[4]);
	}
	if($cantidad_sxmpan==0){
		$interval_sxmpan="No existen registros";
	}else{
		$interval_sxmpan = $f_sxmpan->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMTOR'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmtor = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmtor);
    while($row_sxmtor = oci_fetch_array($consulta_sxmtor)){
        $cantidad_sxmtor = oci_num_rows($consulta_sxmtor);
        $f_sxmtor = new DateTime($row_sxmtor[4]);
	}
	if($cantidad_sxmtor==0){
		$interval_sxmtor="No existen registros";
	}else{
		$interval_sxmtor = $f_sxmtor->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMBOD'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmbod = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmbod);
    while($row_sxmbod = oci_fetch_array($consulta_sxmbod)){
        $cantidad_sxmbod = oci_num_rows($consulta_sxmbod);
        $f_sxmbod = new DateTime($row_sxmbod[4]);
	}if($cantidad_sxmbod==0){
		$interval_sxmbod="No existen registros";
	}else{
		$interval_sxmbod = $f_sxmbod->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMEDO'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmedo = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmedo);
    while($row_sxmedo = oci_fetch_array($consulta_sxmedo)){
        $cantidad_sxmedo = oci_num_rows($consulta_sxmedo);
        $f_sxmedo = new DateTime($row_sxmedo[4]);
	}
	if($cantidad_sxmedo==0){
		$interval_sxmedo="No existen registros";
	}else{
		$interval_sxmedo = $f_sxmedo->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMCAD'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmcad = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmcad);
    while($row_sxmcad = oci_fetch_array($consulta_sxmcad)){
        $cantidad_sxmcad = oci_num_rows($consulta_sxmcad);
        $f_sxmcad = new DateTime($row_sxmcad[4]);
	}
	if($cantidad_sxmcad==0){
		$interval_sxmcad="No existen registros";
	}else{
		$interval_sxmcad = $f_sxmcad->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXROB'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxrob = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxrob);
    while($row_sxrob = oci_fetch_array($consulta_sxrob)){
        $cantidad_sxrob = oci_num_rows($consulta_sxrob);
        $f_sxrob = new DateTime($row_sxrob[4]);
	}
	if($cantidad_sxrob==0){
		$interval_sxrob="No existen registros";
	}else{
		$interval_sxrob = $f_sxrob->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SXMFCI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sxmfci = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sxmfci);
    while($row_sxmfci = oci_fetch_array($consulta_sxmfci)){
        $cantidad_sxmfci = oci_num_rows($consulta_sxmfci);
        $f_sxmfci = new DateTime($row_sxmfci[4]);
	}
	if($cantidad_sxmfci==0){
		$interval_sxmfci="No existen registros";
	}else{
		$interval_sxmfci = $f_sxmfci->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
	FROM INV_MOVIMIENTOS
	WHERE MODC_TIPOMOV = 'SFAACC'
	AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
	AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
	AND ALMN_ALMACEN = '$sucursal'";
				
	$consulta_sfaacc = oci_parse($conexion_central, $cadena_consulta);
	oci_execute($consulta_sfaacc);
	while($row_sfaacc = oci_fetch_array($consulta_sfaacc)){
		$cantidad_sfaacc = oci_num_rows($consulta_sfaacc);
		$f_sfaacc = new DateTime($row_sfaacc[4]);
	}
	if($cantidad_sfaacc==0){
		$interval_sfaacc = "No existen registros";
	}else{
		$interval_sfaacc = $f_sfaacc->diff($now)->format("%d días de retraso");
	}
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SFCBOT'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_sfcbot = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_sfcbot);
    while($row_sfcbot = oci_fetch_array($consulta_sfcbot)){
        $cantidad_sfcbot = oci_num_rows($consulta_sfcbot);
        $f_sfcbot = new DateTime($row_sfcbot[4]);
	}
	if($cantidad_sfcbot==0){
		$interval_sfcbot="No existen registros";
	}else{
		$interval_sfcbot = $f_sfcbot->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'EXVIGI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_exvigi = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_exvigi);
    while($row_exvigi = oci_fetch_array($consulta_exvigi)){
        $cantidad_exvigi = oci_num_rows($consulta_exvigi);
        $f_exvigi = new DateTime($row_exvigi[4]);
	}
	if($cantidad_exvigi==0){
		$interval_exvigi="No existen registros";
	}else{
		$interval_exvigi = $f_exvigi->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'ECHORI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_echori = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_echori);
    while($row_echori = oci_fetch_array($consulta_echori)){
        $cantidad_echori = oci_num_rows($consulta_echori);
        $f_echori = new DateTime($row_echori[4]);
	}
	if($cantidad_echori==0){
		$interval_echori="No existen registros";
	}else{
		$interval_echori = $f_echori->diff($now)->format("%d días de retraso");
	}
	
	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'SCHORI'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_schori = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_schori);
    while($row_schori = oci_fetch_array($consulta_schori)){
        $cantidad_schori = oci_num_rows($consulta_schori);
        $f_schori = new DateTime($row_schori[4]);
	}
	if($cantidad_schori==0){
		$interval_schori="No existen registros";
	}else{
		$interval_schori = $f_schori->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'TRADEP'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_tradep = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_tradep);
    while($row_tradep = oci_fetch_array($consulta_tradep)){
        $cantidad_tradep = oci_num_rows($consulta_tradep);
        $f_tradep = new DateTime($row_tradep[4]);
	}
	if($cantidad_tradep==0){
		$interval_tradep="No existen registros";
	}else{
		$interval_tradep = $f_tradep->diff($now)->format("%d días de retraso");
	}

	$cadena_consulta  = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
    FROM INV_MOVIMIENTOS
    WHERE MODC_TIPOMOV = 'EXCONV'
    AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
    AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
    AND ALMN_ALMACEN = '$sucursal'";
				
    $consulta_exconv = oci_parse($conexion_central, $cadena_consulta);
    oci_execute($consulta_exconv);
    while($row_exconv = oci_fetch_array($consulta_exconv)){
        $cantidad_exconv = oci_num_rows($consulta_exconv);
        $f_exconv = new DateTime($row_exconv[4]);
	}
	if($cantidad_exconv==0){
		$interval_exconv="No existen registros";
	}else{
		$interval_exconv = $f_exconv->diff($now)->format("%d días de retraso");
	}
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
								 ->setTitle("Resumen de Movimientos")
								 ->setSubject("Reporte de movimientos")
								 ->setDescription("Reporte de movimientos")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Movimiento')
                ->setCellValue('B1', 'Cant.')
                ->setCellValue('C1', 'Retraso');

		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('A2', 'Merma Carnicería')
									->setCellValue('B2', $cantidad_sxmcar)
									->setCellValue('C2', $interval_sxmcar)
									->setCellValue('A3', 'Merma Fruta')
									->setCellValue('B3', $cantidad_sxmfta)
									->setCellValue('C3', $interval_sxmfta)
									->setCellValue('A4', 'Merma Panadería')
									->setCellValue('B4', $cantidad_sxmpan)
									->setCellValue('C4', $interval_sxmpan)
									->setCellValue('A5', 'Merma Tortillería')
									->setCellValue('B5', $cantidad_sxmtor)
									->setCellValue('C5', $interval_sxmtor)
									->setCellValue('A6', 'Merma Bodega')
									->setCellValue('B6', $cantidad_sxmbod)
									->setCellValue('C6', $interval_sxmbod)
									->setCellValue('A7', 'Merma Mal Estado')
									->setCellValue('B7', $cantidad_sxmedo)
									->setCellValue('C7', $interval_sxmedo)
									->setCellValue('A8', 'Salida por Robo')
									->setCellValue('B8', $cantidad_sxrob)
									->setCellValue('C8', $interval_sxrob)
									->setCellValue('A9', 'Merma Farmacia')
									->setCellValue('B9', $cantidad_sxmfci)
									->setCellValue('C9', $interval_sxmfci)
									->setCellValue('A10', 'Salida Farm. Accidentes')
									->setCellValue('B10', $cantidad_sfaacc)
									->setCellValue('C10', $interval_sfaacc)
									->setCellValue('A11', 'Salida Farm. Botiquín')
									->setCellValue('B11', $cantidad_sfcbot)
									->setCellValue('C11', $interval_sfcbot)
									->setCellValue('A12', 'Ent. Vigilancia')
									->setCellValue('B12', $cantidad_exvigi)
									->setCellValue('C12', $interval_exvigi)
									->setCellValue('A13', 'Ent. Conv. Chorizo')
									->setCellValue('B13', $cantidad_echori)
									->setCellValue('C13', $interval_echori)
									->setCellValue('A14', 'Sal. Conv. Chorizo')
									->setCellValue('B14', $cantidad_schori)
									->setCellValue('C14', $interval_schori)
									->setCellValue('A15', 'Trans. entre Deptos.')
									->setCellValue('B15', $cantidad_tradep)
									->setCellValue('C15', $interval_tradep)
									->setCellValue('A16', 'Ent. conv. arts.')
									->setCellValue('B16', $cantidad_exconv)
									->setCellValue('C16', $interval_exconv)
									->setCellValue('A17', 'Merma Caducidad')
									->setCellValue('B17', $cantidad_sxmcad)
									->setCellValue('C17', $interval_sxmcad);

         $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
            ->setAutoSize(true);
            
        $objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
            ->setAutoSize(true);
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Resumen de Movimientos');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Movimientos" '.$sucursal.' ".xlsx"');
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
