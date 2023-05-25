<?php
setlocale(LC_ALL, 'es_ES');
include '../global_settings/conexion.php';
//include '../global_settings/conexion_bi.php';
$apiURL="200.1.1.145:9090/api/";

$ActualMonth=date('m');
$dateObj   = DateTime::createFromFormat('!m', $ActualMonth);
$monthName = strftime('%B', $dateObj->getTimestamp());

$fechaInicial=$_POST['fecha_inicial'];
$fechaFinal=$_POST['fecha_final'];
$sucursal=$_POST['sucursal_ADM005'];

$cadenaSuc="SELECT nombre FROM sucursales WHERE id='$sucursal'";
$consultaSuc=mysqli_query($conexion,$cadenaSuc);
$rowSuc=mysqli_fetch_array($consultaSuc);

$IniDateAct=date($fechaInicial);
$FinDateAct=date($fechaFinal);
$AnioAct=date("Y",strtotime($FinDateAct));

$IniDateAnt=date("Y-m-d",strtotime($IniDateAct."- 1 year"));
$FinDateAnt=date("Y-m-d",strtotime($FinDateAct."- 1 year"));
$AnioAnt=date("Y",strtotime($FinDateAnt));
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);
date_default_timezone_set('America/Monterrey');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../plugins/PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = PHPExcel_IOFactory::load("Template_venprov.xlsx");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Josue Villarreal")
							 ->setLastModifiedBy("SysMision")
							 ->setTitle("Reporte Vtas. X Proveedor")
							 ->setSubject("Reportes de Compras")
							 ->setDescription("Reporte de ventas familia por tienda por proveedor, dentro de un rango de fechas.")
							 ->setKeywords("reporte bi excel compras")
							 ->setCategory("Reportes de BI");

//Extraemos la información periodo actual
$curlAct = curl_init();
curl_setopt_array($curlAct, array(
  CURLOPT_URL => $apiURL."GetVentasProveedores?sucursal=".$sucursal."&f_inicial=".$IniDateAct."&f_final=".$FinDateAct,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
$responseAct = curl_exec($curlAct);
curl_close($curlAct);
$arrayAct=json_decode($responseAct, true);
$datosAct=$arrayAct['response']['data'];

//Extraemos información período anterior
$curlAnt = curl_init();
curl_setopt_array($curlAnt, array(
  CURLOPT_URL => $apiURL."GetVentasProveedores?sucursal=".$sucursal."&f_inicial=".$IniDateAnt."&f_final=".$FinDateAnt,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
$responseAnt = curl_exec($curlAnt);
curl_close($curlAnt);
$arrayAnt=json_decode($responseAnt, true);
$datosAnt=$arrayAnt['response']['data'];

//Encabezados
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3','vigencia '.$monthName.' de '.$AnioAct)
            ->setCellValue('B4','Vts $ '.$AnioAct)
            ->setCellValue('C4', 'Vts $ '.$AnioAnt)
            //->setCellValue('D4', '')
            ->setCellValue('E4', 'Unidades '.$AnioAct)
            ->setCellValue('F4', 'Unidades '.$AnioAnt)
            //->setCellValue('G8', '')
            ->setCellValue('H4', 'Margen sin fondos '. $AnioAct)
            ->setCellValue('I4', 'Margen sin fondos '.$AnioAnt)
            ->setCellValue('J4', 'Margen sin fondos '. $AnioAct)
            ->setCellValue('K4', 'Margen sin fondos '.$AnioAnt)
            ->setCellValue('L4', 'Fondos Comerciales '.$AnioAct)
            ->setCellValue('M4', 'Fondos Comerciales LY '.$AnioAnt)
            ->setCellValue('N4', 'Dif $')
            ->setCellValue('O4', 'Margen con fondos '. $AnioAct)
            ->setCellValue('P4', 'Margen con fondos '.$AnioAnt)
            ->setCellValue('Q4', 'Margen + FC '.$AnioAct)
            ->setCellValue('R4', 'Margen + FC LY '.$AnioAnt);
            //->setCellValue('O4', '')
            //->setCellValue('P4', '')
            //->setCellValue('Q4', 'Margen Total  $ '.$AnioAct)
            //->setCellValue('R4', 'Margen Total  $ '.$AnioAnt);

// Add some data
$conteoAct=count($datosAct);
$conteoAnt=count($datosAnt);
if($conteoAct<$conteoAnt){
  $bucle=$conteoAnt;
  $arrayMaster=$datosAnt;
  $arraySlave=$datosAct;
}else{
  $bucle=$conteoAct;
  $arrayMaster=$datosAct;
  $arraySlave=$datosAnt;
}
for($i=0;$i<$bucle; $i++){
  $fila=$i+5;
  $NombreSucursal=$rowSuc[0];
  $NombreProveedor=$arrayMaster[$i]['Nombre'];
  $ClaveProvMaster=$arrayMaster[$i]['ClaveProveedor'];

  //recorrer año actual
  for($p=0;$p<$conteoAct;$p++){
    $provAct=$datosAct[$p]['ClaveProveedor'];
    if($ClaveProvMaster==$provAct){
      $totalUnidadesAct=$datosAct[$p]['Cantidad'];
      $totalUnidadesAct=$totalUnidadesAct-$datosAct[$p]['CantidadDev'];
      $totalDineroAct=$datosAct[$p]['Venta'];
      $totalDineroAct=$totalDineroAct-$datosAct[$p]['VentaDev'];
      $totalCostoAct=$datosAct[$p]['Costo'];
      $totalCostoAct=$totalCostoAct-$datosAct[$p]['CostoDev'];
      $margenAct=$totalDineroAct-$totalCostoAct;
    }
  }

  //Recorrer año anterior
  for($q=0;$q<$conteoAnt; $q++){
    $provAnt=$datosAnt[$q]['ClaveProveedor'];
    if($ClaveProvMaster==$provAnt){
      $totalUnidadesAnt=$datosAnt[$q]['Cantidad'];
      $totalUnidadesAnt=$totalUnidadesAnt-$datosAnt[$q]['CantidadDev'];
      $totalDineroAnt=$datosAnt[$q]['Venta'];
      $totalDineroAnt=$totalDineroAnt-$datosAnt[$q]['VentaDev'];
      $totalCostoAnt=$datosAnt[$q]['Costo'];
      $totalCostoAnt=$totalCostoAnt-$datosAnt[$q]['CostoDev'];
      $margenAnt=$totalDineroAnt-$totalCostoAnt;
    }
  }
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$fila, $ClaveProvMaster)
              ->setCellValue('B'.$fila, $totalDineroAct)
              ->setCellValue('C'.$fila, $totalDineroAnt)
              //->setCellValue('D'.$fila, '')
              ->setCellValue('E'.$fila, $totalUnidadesAct)
              ->setCellValue('F'.$fila, $totalUnidadesAnt)
              //->setCellValue('G'.$fila, '')
              ->setCellValue('H'.$fila, $margenAct)
              ->setCellValue('I'.$fila, $margenAnt)
              //->setCellValue('J'.$fila, '')
              //->setCellValue('K'.$fila, '')
              //->setCellValue('L'.$fila, '')
              //->setCellValue('M'.$fila, '')
              //->setCellValue('N'.$fila, '')
              //->setCellValue('O'.$fila, '')
              //->setCellValue('P'.$fila, '')
              ->setCellValue('Q'.$fila, $margenAct)
              ->setCellValue('R'.$fila, $margenAnt);
  //$result="";
  $totalUnidadesAct=0;
  $totalUnidadesAnt=0;
  $totalDineroAct=0;
  $totalDineroAnt=0;
  $totalCostoAct=0;
  $totalCostoAnt=0;
  $margenAct=0;
  $margenAnt=0;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte Vtas. X Proveedor');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="COM - RepVenTiePro.xlsx"');
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