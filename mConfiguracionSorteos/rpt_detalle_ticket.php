<?php
include '../global_settings/conexion_sucursales.php';
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$frm_inicio = $_POST['fecha_inicial'];
$frm_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

if($sucursal=='1'){
  $conexion_sucursal = $conexion_do;
}elseif($sucursal=='2'){
  $conexion_sucursal = $conexion_arb;
}elseif($sucursal=='3'){
  $conexion_sucursal = $conexion_vill;
}elseif($sucursal=='4'){
  $conexion_sucursal = $conexion_all;
}

ini_set('max_execution_time', 1000); 
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
              ->setLastModifiedBy("La Misión Supermercados")
              ->setTitle("Detalle de artículos")
              ->setSubject("Analisis")
              ->setDescription("Reporte de analisis")
              ->setKeywords("office PHPExcel php")
              ->setCategory("Reportes");

  // Add some data
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A1', 'Ticket')
              ->setCellValue('B1', 'Articulo')
              ->setCellValue('C1', 'Descripción')
              ->setCellValue('D1', 'Familia')
              ->setCellValue('E1', 'Depto.');

$cadena_tickets = "SELECT DISTINCT(folio_ticket) FROM registro_boletos WHERE (fecha >= '$frm_inicio' AND fecha <= '$frm_final') AND sucursal = '$sucursal'";
$consulta_tickets = mysqli_query($conexion, $cadena_tickets);

$fila = 2;
while($row_tickets = mysqli_fetch_array($consulta_tickets)){

  $cadena_artc = "SELECT at.ARTC_ARTICULO,
                  PVS_ARTICULOS.ARTC_ARTICULO,
                  PVS_ARTICULOS.ARTC_DESCRIPCION,
                  (SELECT FAMC_DESCRIPCION FROM PVS_FAMILIAS WHERE FAM.FAMC_FAMILIA_PADRE = PVS_FAMILIAS.FAMC_FAMILIA AND ROWNUM = 1) AS Departamento,
                  FAM.FAMC_DESCRIPCION
                  FROM PVS_ARTICULOSTICKET at INNER JOIN PVS_ARTICULOS ON at.ARTC_ARTICULO = PVS_ARTICULOS.ARTC_ARTICULO
                  INNER JOIN PVS_FAMILIAS FAM ON FAM.FAMC_FAMILIA = PVS_ARTICULOS.ARTC_FAMILIA
                  WHERE CONCAT(at.TICN_AAAAMMDDVENTA,at.TICN_FOLIO) = '$row_tickets[0]'";
  $consulta_artc = oci_parse($conexion_sucursal, $cadena_artc);
  oci_execute($consulta_artc);
  while ($row_artc = oci_fetch_row($consulta_artc)) {
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$fila, $row_tickets[0])
                ->setCellValue('B'.$fila, $row_artc[1])
                ->setCellValue('C'.$fila, $row_artc[2])
                ->setCellValue('D'.$fila, $row_artc[3])
                ->setCellValue('E'.$fila, $row_artc[4]);
    $fila = $fila + 1;
  }
}
//Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('lista_precios');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DetalleTicket.xlsx"');
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
