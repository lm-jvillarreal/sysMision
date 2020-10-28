<?php include("../configuracion/conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_conteo = $_GET['fecha'];
$sucursal = $_GET['sucursal'];


$sql = "SELECT
			c_c.cod_producto,
			c_c.cantidad AS contador,
			c_s.cantidad AS supervisor,
			c_a.cantidad AS auditor,
			p.descripcion,
			m.zona,
			m.mueble,
			m.cara,
			d_m.estante,
			d_m.consecutivo_mueble
		FROM
			conteo_contador AS c_c
		LEFT JOIN conteo_supervisor AS c_s ON c_s.id_detalle_mapeo = c_c.id_detalle_mapeo
		LEFT JOIN conteo_auditor AS c_a ON c_a.id_detalle_mapeo = c_c.id_detalle_mapeo
		INNER JOIN productos AS p ON p.codigo_producto = c_c.cod_producto
		INNER JOIN detalle_mapeo AS d_m ON d_m.id = c_c.id_detalle_mapeo
		INNER JOIN mapeo AS m ON m.id = d_m.id_mapeo
		WHERE
			m.fecha_conteo = '$fecha_conteo'
		AND m.activo = 0
		AND m.id_sucursal = '$sucursal'
		ORDER BY
			d_m.estante, d_m.consecutivo_mueble";

$consulta_proveedor=mysqli_query($conexion,$sql);

	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
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
	            ->setCellValue('A1', 'Zona')
	            ->setCellValue('B1', 'Mueble')
	            ->setCellValue('C1', 'Cara')
	            ->setCellValue('D1', 'Nivel')
	            ->setCellValue('E1', 'Consecutivo')
	            ->setCellValue('F1', 'Codigo')
	            ->setCellValue('G1', 'Descripcion')
	            ->setCellValue('H1', 'Cantidad');


	$fila = 2;
	while($row = mysqli_fetch_array($consulta_proveedor))
	{
		        if (is_null($row[3]) && empty($row[2])) {
		          $valor_final = $row[1];
		        }
		        elseif(is_null($row[3])){
		          $valor_final = $row[2];
		        }
		        else{
		          $valor_final = $row[3];
		        }

		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row[5])
	            ->setCellValue('B'.$fila, $row[6])
	            ->setCellValue('C'.$fila, $row[7])
	            ->setCellValue('D'.$fila, $row[8])
	            ->setCellValue('E'.$fila, $row[9])
	            ->setCellValue('F'.$fila, $row[0])
	            ->setCellValue('G'.$fila, $row[4])
	            ->setCellValue('H'.$fila, $valor_final);

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

	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('H')
    		->setAutoSize(true);	
	$fila = $fila + 1;
	}

	$captura = "SELECT
					m.zona,
					m.mueble,
					m.cara,
					d_m.estante,
					d_m.consecutivo_mueble,
					d_m.codigo_producto,
					p.descripcion,
					c.cantidad
				FROM
					mapeo AS m
				INNER JOIN detalle_mapeo AS d_m ON d_m.id_mapeo = m.id
				INNER JOIN productos AS p ON p.codigo_producto = d_m.codigo_producto
				INNER JOIN captura AS c ON c.id_detalle_mapeo = d_m.id
				WHERE m.fecha_conteo = '$fecha_conteo'
				AND m.id_sucursal = '$sucursal'
				AND m.activo = 0";
	$exCaptura = mysqli_query($conexion, $captura);
	while($rowC = mysqli_fetch_array($exCaptura))
	{

		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $rowC[0])
	            ->setCellValue('B'.$fila, $rowC[1])
	            ->setCellValue('C'.$fila, $rowC[2])
	            ->setCellValue('D'.$fila, $rowC[3])
	            ->setCellValue('E'.$fila, $rowC[4])
	            ->setCellValue('F'.$fila, $rowC[5])
	            ->setCellValue('G'.$fila, $rowC[6])
	            ->setCellValue('H'.$fila, $rowC[7]);
	$fila = $fila + 1;
	}
	$cap_excel = "SELECT
						m.zona,
						m.mueble,
						m.cara,
						c_e.codigo,
						p.descripcion,
						c_e.cantidad
					FROM
						mapeo AS m
					INNER JOIN captura_excel AS c_e ON c_e.id_mapeo = m.id
					INNER JOIN productos AS p ON p.codigo_producto = c_e.codigo
					WHERE m.fecha_conteo = '$fecha_conteo'
					AND m.id_sucursal = '$sucursal'";

	$exCapExcel = mysqli_query($conexion, $cap_excel);
	while($rowCE = mysqli_fetch_array($exCapExcel))
	{

		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $rowCE[0])
	            ->setCellValue('B'.$fila, $rowCE[1])
	            ->setCellValue('C'.$fila, $rowCE[2])
	            ->setCellValue('D'.$fila, "x")
	            ->setCellValue('E'.$fila, "x")
	            ->setCellValue('F'.$fila, $rowCE[3])
	            ->setCellValue('G'.$fila, $rowCE[4])
	            ->setCellValue('H'.$fila, $rowCE[5]);
	$fila = $fila + 1;
	}	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Reportes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reportes" '.$fecha_conteo.' ".xlsx"');
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
