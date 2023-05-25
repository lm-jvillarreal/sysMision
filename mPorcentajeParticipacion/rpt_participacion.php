<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

$inicio = str_replace("-", "", $_POST['fecha_inicio']);
$final = str_replace("-", "", $_POST['fecha_final']);
$departamento = $_POST['departamento'];
//Descargamos, creamos e inicializamos las variables de uso Local
$cadena_consulta  = "SELECT ARTC_ARTICULO, ARTC_DESCRIPCION,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='1' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) DO,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='2' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) ARB,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='3' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) VILL,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='4' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) ALLE,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='5' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) PET,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final' AND ticc_sucursal='6' AND NOT(ARTC_ARTICULOAFECTACION IS NULL)) MMORELOS,
                      (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO=A.ARTC_ARTICULO AND ticn_aaaammddventa>='$inicio' AND ticn_aaaammddventa<='$final') TOTAL
                      FROM COM_ARTICULOS A INNER JOIN COM_FAMILIAS familias ON FAMILIAS.FAMC_FAMILIA = ARTC_FAMILIA
                      WHERE A.ARTN_ESTATUS = 1 AND
                      FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
							
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
								 ->setTitle("Porcentaje de Parricipación")
								 ->setSubject("Reporte de operaciones")
								 ->setDescription("Reporte de operaciones")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'ARTICULO')
	            ->setCellValue('B1', 'DESCRIPCION')
	            ->setCellValue('C1', 'DO (Σ)')
	            ->setCellValue('D1', 'ARB (Σ)')
	            ->setCellValue('E1', 'VILL (Σ)')
              ->setCellValue('F1', 'ALL (Σ)')
              ->setCellValue('G1', 'PET (Σ)')
              ->setCellValue('H1', 'MMORELOS (Σ)')
              ->setCellValue('I1', 'TOTAL (Σ)')
              ->setCellValue('J1', 'DO (%)')
              ->setCellValue('K1', 'ARB (%)')
              ->setCellValue('L1', 'VILL (%)')
              ->setCellValue('M1', 'ALL (%)')
              ->setCellValue('N1', 'PET (%)')
              ->setCellValue('O1', 'MMORELOS (%)')
              ->setCellValue('P1', 'TOTAL (%)');

  $totalDO=0;
  $totalARB=0;
  $totalVILL=0;
  $totalALL=0;
  $totalPET=0;
  $totalMMORELOS=0;
  $totalGeneral=0;

  
  $fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{
    $fila2=$fila+1;
		//$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
    $totalDO=$totalDO+$row_principal[2]; 
    $totalARB=$totalARB+$row_principal[3];
    $totalVILL=$totalVILL+$row_principal[4];
    $totalALL=$totalALL+$row_principal[5];
    $totalPET=$totalPET+$row_principal[6];
    $totalMMORELOS=$totalMMORELOS+$row_principal[7];
    $totalGeneral=$totalGeneral+$row_principal[8];

    if($row_principal[7]=='0'){
      $pDO=0;
      $pARB=0;
      $pVILL=0;
      $pALL=0;
      $pPET=0;
      $pMMORELOS=0;
      $pTotal=0;
    }else{
      if($row_principal[2]=='0'){
        $pDO=0;
      }else{
        $pDO=($row_principal[2]/$row_principal[8])*100;
      }
      if($row_principal[3]=='0'){
        $pARB=0;
      }else{
        $pARB=($row_principal[3]/$row_principal[8])*100;
      }
      if($row_principal[4]=='0'){
        $pVILL=0;
      }else{
        $pVILL=($row_principal[4]/$row_principal[8])*100;
      }
      if($row_principal[5]=='0'){
        $pALL=0;
      }else{
        $pALL=($row_principal[5]/$row_principal[8])*100;
      }
      if($row_principal[6]=='0'){
        $pPET=0;
      }else{
        $pPET=($row_principal[6]/$row_principal[8])*100;
      }
      if($row_principal[7]=='0'){
        $pMMORELOS=0;
      }else{
        $pMMORELOS=($row_principal[7]/$row_principal[8])*100;
      }
      $pTotal=($row_principal[8]/$row_principal[8])*100;

      $pDO = round($pDO,2).'%';
      $pARB = round($pARB,2).'%';
      $pVILL = round($pVILL,2).'%';
      $pALL = round($pALL,2).'%';
      $pPET= round($pPET,2).'%';
      $pMMORELOS= round($pMMORELOS,2).'%';
      $pTotal = round($pTotal,2).'%';
    }

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
                ->setCellValue('J'.$fila, $pDO)
                ->setCellValue('K'.$fila, $pARB)
                ->setCellValue('L'.$fila, $pVILL)
                ->setCellValue('M'.$fila, $pALL)
                ->setCellValue('N'.$fila, $pPET)
                ->setCellValue('O'.$fila, $pMMORELOS)
                ->setCellValue('P'.$fila, $pTotal)
                ->setCellValue('A'.$fila2, 'TOTAL GENERAL')
                ->setCellValue('C'.$fila2, $totalDO)
                ->setCellValue('D'.$fila2, $totalARB)
                ->setCellValue('E'.$fila2, $totalVILL)
                ->setCellValue('F'.$fila2, $totalALL)
                ->setCellValue('G'.$fila2, $totalPET)
                ->setCellValue('H'.$fila2, $totalMMORELOS)
                ->setCellValue('I'.$fila2, $totalGeneral);


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
  $fila3=$fila+2;
  }
  $porcDO=($totalDO/$totalGeneral)*100;
  $porcDO=round($porcDO,2).'%';
  $porcARB=($totalARB/$totalGeneral)*100;
  $porcARB=round($porcARB,2).'%';
  $porcVILL=($totalVILL/$totalGeneral)*100;
  $porcVILL=round($porcVILL,2).'%';
  $porcALL=($totalALL/$totalGeneral)*100;
  $porcALL=round($porcALL,2).'%';
  $porcPET=($totalPET/$totalGeneral)*100;
  $porcPET=round($porcPET,2).'%';
  $porcGeneral=($totalGeneral/$totalGeneral)*100;
  $porcGeneral=round($porcGeneral,2).'%';
  $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$fila3, 'PORCENTAJE GENERAL')
                ->setCellValue('C'.$fila3, $porcDO)
                ->setCellValue('D'.$fila3, $porcARB)
                ->setCellValue('E'.$fila3, $porcVILL)
                ->setCellValue('F'.$fila3, $porcALL)
                ->setCellValue('G'.$fila3, $porcPET)
                ->setCellValue('H'.$fila3, $porcGeneral);
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="PorcentajeParticipacion.xlsx"');
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
