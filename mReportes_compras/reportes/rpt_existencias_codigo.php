<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$sucursal = $_POST['sucursal'];
$familia = $_POST['familia'];
$array = $_POST['array'];
$arra = explode(',', $array);
$cantidad = count($arra);
$departamento = $_POST['departamento'];
$or="";

if ($departamento == "" && $proveedor == "" && $familia == "") {
	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
		$consulta_principal  = "SELECT
									ARTC_ARTICULO,
									ARTC_DESCRIPCION,
									COM_FAMILIAS.FAMC_DESCRIPCION,
									(
										SELECT
											FAMC_DESCRIPCION
										FROM
											COM_FAMILIAS F
										WHERE
											F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
									)
								FROM
									COM_ARTICULOS
								INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
								WHERE
									(
										ARTC_ARTICULO = '$arra[0]'".$or."
									)";	
}

if ($departamento != "") {
	$consulta_principal = "SELECT
							ARTC_ARTICULO,
							ARTC_DESCRIPCION,
							COM_FAMILIAS.FAMC_DESCRIPCION,
							(
								SELECT
									FAMC_DESCRIPCION
								FROM
									COM_FAMILIAS F
								WHERE
									F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
							)
						FROM
							COM_ARTICULOS
						INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
						WHERE
							COM_FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
}

if ($familia != "") {
	$consulta_principal = "SELECT
							ARTC_ARTICULO,
							ARTC_DESCRIPCION,
							COM_FAMILIAS.FAMC_DESCRIPCION,
							(
								SELECT
									FAMC_DESCRIPCION
								FROM
									COM_FAMILIAS F
								WHERE
									F.FAMC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIAPADRE
							)
						FROM
							COM_ARTICULOS
						INNER JOIN COM_FAMILIAS ON COM_FAMILIAS.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
						WHERE
							COM_ARTICULOS.ARTC_FAMILIA = '$familia'";
}





		
						// echo "$consulta_principal";
						// echo "$fecha_fin";
						// echo "$fecha_i";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);


	/** Error reporting */
	//error_reporting(E_ALL);
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
	            ->setCellValue('A1', 'Codigo')
	            ->setCellValue('B1', 'Departamento')
	            ->setCellValue('C1', 'Familia')
	            ->setCellValue('D1', 'Descripcion')
	            ->setCellValue('E1', 'Existencia');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$qry_existencia = "SELECT spin_articulos.fn_existencia_disponible_todos (
									13,
									NULL,
									NULL,
									1,
									1,
									'$sucursal',
									'$row_principal[0]'
								) FROM dual";
		$ste = oci_parse($conexion_central, $qry_existencia);
		oci_execute($ste);
		$row_existencia = oci_fetch_row($ste);
	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[3])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[1]);
				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('E'.$fila, $row_existencia[0]);

	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

    	
  
	$fila = $fila + 1;
	}


	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Existencias');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Existencias" '.$sucursal.' ".xlsx"');
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
