<?php 
include "../global_settings/conexion.php";
include '../global_settings/conexion_oracle.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_conteo = $_GET['fecha'];
$sucursal = $_GET['sucursal'];

$cadenaEliminar = "DROP TEMPORARY TABLE IF EXISTS fisico;";
$eliminaTemporal = mysqli_query($conexion,$cadenaEliminar);

$cadenaTemporal = "CREATE TEMPORARY TABLE fisico AS
									SELECT mapeo.id, captura.cod_producto, ifnull(captura.cantidad,0) as cantidad
									FROM inv_mapeo as mapeo 
									INNER JOIN inv_captura as captura ON mapeo.id = captura.id_mapeo
									where mapeo.id_sucursal = '$sucursal'
									and mapeo.fecha_conteo = '$fecha_conteo'
									and mapeo.activo = '0'
									order by captura.cod_producto asc;";
$consultaTemporal = mysqli_query($conexion, $cadenaTemporal);

$qry = "SELECT DISTINCT(cod_producto), SUM(cantidad) FROM fisico group by cod_producto;";
$consulta_proveedor=mysqli_query($conexion, $qry);

	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte - Conteos")
								 ->setSubject("PHPExcel Test Document")
								 ->setDescription("Reporte de inventarios")
								 ->setKeywords("La Misión Supermercados")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Codigo')
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Cantidad')
	            ->setCellValue('D1', 'Existencia')
	            ->setCellValue('E1', 'Diferencia')
	            ->setCellValue('F1', 'Ultimo Costo')
	            ->setCellValue('G1', 'Precio Publico')
	            ->setCellValue('H1', 'Diferencia $ Costo')
	            ->setCellValue('I1', 'Diferencia $ PP');



	$fila = 2;
	while($row = mysqli_fetch_array($consulta_proveedor))
	{
		$qry_existencia = "SELECT ARTC_DESCRIPCION, (SELECT
										spin_articulos.fn_existencia_disponible_todos (
											13,
											NULL,
											NULL,
											1,
											1,
											'$sucursal',
											'$row[0]'
										)
									FROM
										dual
								)
							FROM
								PV_ARTICULOS
							WHERE
								ARTC_ARTICULO = '$row[0]'";
		$st_existencia = oci_parse($conexion_central, $qry_existencia);
		oci_execute($st_existencia);
		$row_existencia = oci_fetch_row($st_existencia);

		$qry_datos = "SELECT 
							ARTC_ARTICULO,
		 					artn_precioventa,
		 					artc_tipoimpuesto1,
		 					artc_tipoimpuesto2,
						CASE 
						    WHEN ARTC_TIPOIMPUESTO1 = '16' AND ARTC_TIPOIMPUESTO2 = 'IEPS6'
						    THEN ROUND(ARTN_PRECIOVENTA * 1.22, 2)
						    WHEN ARTC_TIPOIMPUESTO2 = 'IEPS'
						    THEN ROUND(ARTN_PRECIOVENTA * 1.08, 2)
						    WHEN ARTC_TIPOIMPUESTO1 IS NULL AND ARTC_TIPOIMPUESTO2 = 'IEPS6' 
						    THEN ROUND(ARTN_PRECIOVENTA * 1.06, 2)
						    WHEN ARTC_TIPOIMPUESTO1 = 'CERO' AND ARTC_TIPOIMPUESTO2 IS NULL
						    THEN  ARTN_PRECIOVENTA
						END CASE,
						(SELECT ARTN_ULTIMOPRECIO FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$row[0]') AS U_P
						FROM PV_ARTICULOS
						WHERE ARTC_ARTICULO = '$row[0]'";
		$st_datos = oci_parse($conexion_central, $qry_datos);
		oci_execute($st_datos);
		$row_datos = oci_fetch_row($st_datos);

		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row[0])
	            ->setCellValue('B'.$fila, $row_existencia[0])
	            ->setCellValue('C'.$fila, $row[1])
	            ->setCellValue('D'.$fila, $row_existencia[1])
	            ->setCellValue('E'.$fila, $row[1] - $row_existencia[1])
	            ->setCellValue('F'.$fila, $row_datos[5])
	            ->setCellValue('G'.$fila, $row_datos[4])
	            ->setCellValue('H'.$fila, ($row[1]-$row_existencia[1]) * $row_datos[5])
	            ->setCellValue('I'.$fila, ($row[1]-$row_existencia[1]) * $row_datos[4]);

	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(true);
	$fila = $fila + 1;
	}
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Reportes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="reporte" '.$fecha_conteo.' ".xlsx"');
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
