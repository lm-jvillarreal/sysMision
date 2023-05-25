<?php
setlocale(LC_ALL, 'es_ES');
include '../global_settings/conexion.php';
//include '../global_settings/conexion_bi.php';
$apiURL="200.1.1.145:9090/api/";

$ActualMonth=date('m');
$dateObj   = DateTime::createFromFormat('!m', $ActualMonth);
$monthName = strftime('%B', $dateObj->getTimestamp());

$cadenaSucursales = "SELECT id, nombre FROM sucursales WHERE ACTIVO=1 and nombre != 'CEDIS' ORDER BY id ASC";
$consultaSucursales=mysqli_query($conexion,$cadenaSucursales);

$fechaInicial=$_POST['fecha_inicial'];
$fechaFinal=$_POST['fecha_final'];

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
$objPHPExcel = PHPExcel_IOFactory::load("Template_ventie.xlsx");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Josue Villarreal")
							 ->setLastModifiedBy("SysMision")
							 ->setTitle("Reporte Vtas. X Tienda")
							 ->setSubject("Reportes de Compras")
							 ->setDescription("Reporte de ventas por tienda, dentro de un rango de fechas.")
							 ->setKeywords("reporte bi excel compras")
							 ->setCategory("Reportes de BI");

//Extraemos la información periodo actual
$curlAct = curl_init();
curl_setopt_array($curlAct, array(
  CURLOPT_URL => $apiURL."GetTotalesSucursal?f_inicial=".$IniDateAct."&f_final=".$FinDateAct,
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

//Extraemos información período anterior
$curlAnt = curl_init();
curl_setopt_array($curlAnt, array(
  CURLOPT_URL => $apiURL."GetTotalesSucursal?f_inicial=".$IniDateAnt."&f_final=".$FinDateAnt,
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

//Encabezados
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B4','Vigencia en el mes de '.$monthName)
            ->setCellValue('C4',$AnioAct)
            ->setCellValue('D8', $AnioAct)
            ->setCellValue('E8', $AnioAnt)
            ->setCellValue('F8', $AnioAct.' vs '.$AnioAnt)
            ->setCellValue('H8', 'Presup. '.$AnioAct)
            ->setCellValue('K8', $AnioAct)
            ->setCellValue('L8', $AnioAnt)
            ->setCellValue('M8', $AnioAct.' vs '.$AnioAnt)
            ->setCellValue('O8', $AnioAct)
            ->setCellValue('P8', $AnioAnt)
            ->setCellValue('R8', $AnioAct)
            ->setCellValue('S8', $AnioAct)
            ->setCellValue('T8', $AnioAnt)
            ->setCellValue('U8', $AnioAnt)
            ->setCellValue('V8', $AnioAct)
            ->setCellValue('W8', $AnioAct)
            ->setCellValue('X8', $AnioAnt)
            ->setCellValue('Y8', $AnioAnt)
            ->setCellValue('Z8', $AnioAct)
            ->setCellValue('AA8', $AnioAct)
            ->setCellValue('AB8', $AnioAnt)
            ->setCellValue('AC8', $AnioAnt)
            ->setCellValue('AD8', $AnioAct)
            ->setCellValue('AE8', $AnioAct);

// Add some data
while($rowSucursal=mysqli_fetch_array($consultaSucursales)){
  //Extraemos y volcamos las sucursales
	$posicion=$rowSucursal[0]-1;
  $fila=$rowSucursal[0]+8;

  //Total de venta
  $totalDineroAct=$arrayAct["response"]["data"][$posicion]["TotalDinero"]-$arrayAct["response"]["data"][$posicion]["DevolucionPrecio"];
  $totalDineroAnt=$arrayAnt["response"]["data"][$posicion]["TotalDinero"]-$arrayAct["response"]["data"][$posicion]["DevolucionPrecio"];

  //Total de costo de lo vendido
  $totalCostoAct=$arrayAct["response"]["data"][$posicion]["TotalCosto"]-$arrayAct["response"]["data"][$posicion]["DevolucionCosto"];
  $totalCostoAnt=$arrayAnt["response"]["data"][$posicion]["TotalCosto"]-$arrayAct["response"]["data"][$posicion]["DevolucionCosto"];

  //Total de unidades vendidas
  $totalUnidadesAct=$arrayAct["response"]["data"][$posicion]["TotalUnidades"]-$arrayAct["response"]["data"][$posicion]["Devolucion"];
  $totalUnidadesAnt=$arrayAnt["response"]["data"][$posicion]["TotalUnidades"]-$arrayAct["response"]["data"][$posicion]["Devolucion"];

  //Total de margen
  $margenAct=$totalDineroAct-$totalCostoAct;
  $margenAnt=$totalDineroAnt-$totalCostoAnt;

  $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B'.$fila, $rowSucursal[1])
	->setCellValue('D'.$fila, $totalDineroAct)
	->setCellValue('K'.$fila, $totalUnidadesAct)
	->setCellValue('E'.$fila, $totalDineroAnt)
	->setCellValue('L'.$fila, $totalUnidadesAnt)
  ->setCellValue('R'.$fila, $margenAct)
  ->setCellValue('T'.$fila, $margenAnt);
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte Vtas. X Tienda');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="COM - RepVenTie.xlsx"');
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