<?php 
//include("conexion_servidor.php");
include '../global_settings/conexion_supsys.php';
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$proveedor = $_POST['proveedor'];
$codigo = $_POST['codigo'];
$familia = $_POST['familia'];


$consulta_principal  = "SELECT
							cajas_articulos.id,
							articulos_cajas.codigo AS articulo,
							cajas_articulos.codigo AS caja,
							cajas_articulos.descripcion,
							articulos_cajas.cantidad,
							productos.descripcion
						FROM
							articulos_cajas
							INNER JOIN cajas_articulos ON articulos_cajas.id_caja = cajas_articulos.id 
							INNER JOIN productos on productos.codigo_producto = articulos_cajas.codigo
						GROUP BY
							cajas_articulos.id";
							//echo "$consulta_principal";
$exQry = mysqli_query($conexion, $consulta_principal);




	
	
	
	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once '../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Analisis")
								 ->setDescription("Reporte de analisis")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Codigo pieza')
	            ->setCellValue('B1', 'Descripcion Art')
	            ->setCellValue('C1', 'Codigo empaque')
	            ->setCellValue('D1', 'Descripcion Codigo empaque')
	            ->setCellValue('E1', 'Cantidad de piezas');


	$fila = 2;
	while($row_principal = mysqli_fetch_row($exQry))
	{


	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[1])
	            ->setCellValue('B'.$fila, $row_principal[5])	            
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, $row_principal[4]);




	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

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
        
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('I')
        ->setAutoSize(true);
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('J')
        ->setAutoSize(true);
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('K')
        ->setAutoSize(true);

                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('L')
        ->setAutoSize(true);

                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('M')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('N')
        ->setAutoSize(true);
        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('O')
        ->setAutoSize(true);        
	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="rpt_analisis" '.$Msucursal.$fecha.' ".xlsx"');
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
