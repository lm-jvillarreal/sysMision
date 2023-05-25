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
$sucursal=$_POST['sucursal_ADM004'];

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
$objPHPExcel = PHPExcel_IOFactory::load("Template_vendepto.xlsx");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Josue Villarreal")
							 ->setLastModifiedBy("SysMision")
							 ->setTitle("Reporte Vtas. X Departamento")
							 ->setSubject("Reportes de Compras")
							 ->setDescription("Reporte de ventas por departamento por tienda, dentro de un rango de fechas.")
							 ->setKeywords("reporte bi excel compras")
							 ->setCategory("Reportes de BI");

//Extraemos la información periodo actual
$curlAct = curl_init();
curl_setopt_array($curlAct, array(
  CURLOPT_URL => $apiURL."GetVentasDeptoSucursal?sucursal=".$sucursal."&f_inicial=".$IniDateAct."&f_final=".$FinDateAct,
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
$conteoAct=count($datosAct);

//Extraemos la información del período anterior
$curlAnt = curl_init();
curl_setopt_array($curlAnt, array(
  CURLOPT_URL => $apiURL."GetVentasDeptoSucursal?sucursal=".$sucursal."&f_inicial=".$IniDateAnt."&f_final=".$FinDateAnt,
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
$conteoAnt=count($datosAnt);

//Encabezados
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C4','vigencia '.$monthName.' de '.$AnioAct)
            ->setCellValue('D8', $AnioAct)
            ->setCellValue('E8', $AnioAnt)
            ->setCellValue('F8', $AnioAct.' vs '.$AnioAnt)
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
    $fila=$i+9;
    $NombreSucursal=$rowSuc[0];
    $NombreDepto=$arrayMaster[$i]['Nombre'];
    $DeptoMaster=$arrayMaster[$i]['ClaveDepartamento'];
  
    //recorrer año actual
    for($p=0;$p<$conteoAct;$p++){
      $deptoAct=$datosAct[$p]['ClaveDepartamento'];
      if($DeptoMaster==$deptoAct){
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
      $deptoAnt=$datosAnt[$q]['ClaveDepartamento'];
      if($DeptoMaster==$deptoAnt){
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
                ->setCellValue('B'.$fila, $FinDateAct)
                ->setCellValue('C'.$fila, $NombreDepto)
                ->setCellValue('D'.$fila, $totalDineroAct)
                ->setCellValue('E'.$fila, $totalDineroAnt)
                ->setCellValue('K'.$fila, $totalUnidadesAct)
                ->setCellValue('L'.$fila, $totalUnidadesAnt)
                ->setCellValue('R'.$fila, $margenAct)
                ->setCellValue('T'.$fila, $margenAnt);
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
$objPHPExcel->getActiveSheet()->setTitle('Reporte Vtas. X Departamento');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="COM - RepVenTieDep.xlsx"');
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