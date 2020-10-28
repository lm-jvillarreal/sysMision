<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../global_settings/conexion_oracle.php';
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_fin=str_replace("-","",$fecha_final);
// $tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$codigo = $_POST['codigo'];




$consulta_principal  = "SELECT
							PV_TICKETS.TICN_AAAAMMDDVENTA,
							PV_TICKETS.TICN_FOLIO
						FROM
							PV_TICKETS
						INNER JOIN PV_ARTICULOSTICKET ON PV_TICKETS.TICN_AAAAMMDDVENTA = PV_ARTICULOSTICKET.TICN_AAAAMMDDVENTA
						AND PV_TICKETS.TICC_SUCURSAL = PV_ARTICULOSTICKET.TICC_SUCURSAL
						AND PV_ARTICULOSTICKET.TICN_FOLIO = PV_TICKETS.TICN_FOLIO
						WHERE
							PV_TICKETS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i'
						AND '$fecha_fin'
						AND PV_TICKETS.TICN_TIPOMOV = '1'
						AND PV_TICKETS.TICC_SUCURSAL = '$sucursal'
						AND PV_ARTICULOSTICKET.ARTC_ARTICULO = '$codigo'
						ORDER BY
							PV_TICKETS.TICN_AAAAMMDDVENTA,
							PV_TICKETS.TICN_FOLIO";
							//echo "$consulta_principal";





	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);



//$registros = mysql_num_rows ($resultado_principal);


	ini_set('memory_limit', '-1');
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

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Devoluciónes")
								 ->setDescription("Reporte de las Devoluciónes")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Articulo')
	            ->setCellValue('B1', 'Cantidad');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$sql = "SELECT
					ARTC_ARTICULO, COUNT(CTBS_CIA)
				FROM
					PV_ARTICULOSTICKET
				WHERE
					TICN_AAAAMMDDVENTA = '$row_principal[0]'
				AND TICC_SUCURSAL = '$sucursal'
				AND TICN_FOLIO = '$row_principal[1]'
				GROUP BY ARTC_ARTICULO";
		$exSql = oci_parse($conexion_central, $sql);
		oci_execute($exSql);
		while ($r = oci_fetch_row($exSql)) {
			$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $r[0])
	            ->setCellValue('B'.$fila, $r[1]);
	            $fila = $fila + 1;
		}




	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Coincidencias');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Coincidencias" '.$fecha.' ".xlsx"');
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
