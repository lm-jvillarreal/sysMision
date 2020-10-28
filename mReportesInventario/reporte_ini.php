<?php include("../global_settings/conexion.php");
include '../global_settings/conexion_oracle.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
//$fecha_conteo = $_GET['fecha'];
//$sucursal = $_GET['sucursal'];
$departamento = $_GET['cmbDpto'];
$sucursal = $_GET['cmbSucursal'];



$qry = "SELECT
			detalle.ARTC_ARTICULO,
			detalle.ARTC_DESCRIPCION,
			(
				SELECT
					spin_articulos.fn_existencia_disponible_todos (
						13,
						NULL,
						NULL,
						1,
						1,
						'$sucursal',
						DETALLE.ARTC_ARTICULO
					)
				FROM
					dual
			) AS ExistenciaDiazOrdaz
		FROM
			INV_ARTICULOS_DETALLE detalle
		INNER JOIN COM_FAMILIAS familias ON FAMILIAS.FAMC_FAMILIA = ARTC_FAMILIA 
         WHERE FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
$consulta_proveedor=oci_parse($conexion_central, $qry);
oci_execute($consulta_proveedor);

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
	            ->setCellValue('D1', 'Capturado');



	$fila = 2;
	while($row = oci_fetch_row($consulta_proveedor))
	{

		$sql_cantidad = "SELECT IFNULL(SUM(cantidad), 0) 
						FROM inv_captura 
						INNER JOIN inv_mapeo ON inv_mapeo.id = inv_captura.id_mapeo 
						WHERE cod_producto = '$row[0]'
						AND inv_mapeo.id_sucursal = '1'";
		$exCantidad = mysqli_query($conexion, $sql_cantidad);
		$r_cantidad = mysqli_fetch_row($exCantidad);
		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row[0])
	            ->setCellValue('B'.$fila, $row[1])
	            ->setCellValue('C'.$fila, $row[2])
	            ->setCellValue('D'.$fila, $r_cantidad[0]);

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
	header('Content-Disposition: attachment;filename="reporte" '."-".' ".xlsx"');
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
