<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

$fecha = str_replace("-","",$_POST['fecha']);
$sucursal = $_POST['sucursal'];
//Descargamos, creamos e inicializamos las variables de uso Local
$cadena_consulta  = "
SELECT
    DISTINCT(artc.artc_articulo) articulo,
    lista.artc_descripcion,
    SUM(artc.artn_cantidad) cantidad,
    FAM.FAMC_DESCRIPCION,
    artc.ticn_folio,
    TO_CHAR(tkt.TICD_FECHAHORAVENTA, 'DD/MM/YYYY') Fecha,
    TO_CHAR(tkt.TICD_FECHAHORAVENTA, 'hh24:mi:ss') Hora
    FROM pv_articulosticket artc 
    INNER JOIN pv_tickets tkt ON tkt.ticc_sucursal = artc.ticc_sucursal
    INNER JOIN com_articulos lista ON artc.artc_articulo = lista.artc_articulo
    INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = lista.ARTC_FAMILIA
    AND tkt.ticn_folio = artc.ticn_folio
    wHERE tkt.TICN_AAAAMMDDVENTA = '$fecha'
    AND artc.ticn_aaaammddventa = '$fecha'
    AND artc.ticc_sucursal = '$sucursal'
    AND tkt.TICC_SUCURSAL = '$sucursal'
    GROUP BY artc.artc_articulo, artc.ticn_folio, lista.artc_descripcion, tkt.TICD_FECHAHORAVENTA, tkt.TICD_FECHAHORAVENTA, FAM.FAMC_DESCRIPCION
    ORDER BY artc.ticn_folio asc
";
							
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
								 ->setTitle("Listado Detalle Ventas")
								 ->setSubject("Reporte de compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Articulo')
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Cantidad')
	            ->setCellValue('D1', 'Familia')
	            ->setCellValue('E1', 'Operacion')
	            ->setCellValue('F1', 'Fecha')
                ->setCellValue('G1', 'Hora');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{
		$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, $row_principal[4])
	            ->setCellValue('F'.$fila, $row_principal[5])
                ->setCellValue('G'.$fila, $row_principal[6]);



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
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de Ventas');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="ReporteVentasDetallado.xlsx"');
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
