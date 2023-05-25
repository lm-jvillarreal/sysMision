<?php
// esto permite tener acceso desde otro servidor
    //header('Access-Control-Allow-Origin: *');
  // esto permite tener acceso desde otro servidor
// include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion.php';
include '../global_settings/consulta_sqlsrvr.php';

error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$folio = $_POST['folio'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$fecha_uno = $_POST['fecha_uno'];
$fecha_dos = $_POST['fecha_dos'];
$filtro="";

if($sucursal == '1'){
    $filtro=" AND sucursal='DIAZ ORDAZ'";
    }else if($sucursal == '2'){
      $filtro=" AND sucursal='ARBOLEDAS'";
    }else if($sucursal == '3'){
      $filtro=" AND sucursal='VILLEGAS'";
    }else if($sucursal == '4'){
      $filtro=" AND sucursal='ALLENDE'";
    }else if($sucursal == '5'){
      $filtro="AND sucursal='PETACA'";
    }else if($sucursal == '99'){
      $filtro ="AND sucursal= 'CEDIS'";
    }else{
      $filtro="";
    }


	$cadena_consulta= "SELECT
	id,
	nombre,
	departamento,
	  sucursal,
	  (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.		 id_persona WHERE usuarios.id = tiempo_extra.usuario),
	  tiempo,
	  comentario,
	  date_format(fecha_inicio,'%d/%m/%Y') as Fecha,
	  date_format(fecha,'%d/%m/%Y') as Fecha_Dos,
	  folio,
	  motivo,
	  hora_inicio,
	  hora_final
	  FROM
	  tiempo_extra 
	  WHERE
	  activo = '1' 
	  AND fecha >='$fecha_uno' and fecha <= '$fecha_dos'".$filtro;

$consulta_detalle = mysqli_query($conexion, $cadena_consulta);

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
	$objPHPExcel->getProperties()->setCreator("Angeles Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte Tiempo Extra")
								 ->setSubject("Análisis")
								 ->setDescription("Reporte de Análisis")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Sucursal')
				->setCellValue('B1', 'Motivo')
				->setCellValue('C1', 'Departamento')
				->setCellValue('D1', 'Empleado')
				->setCellValue('E1', '')
				->setCellValue('F1', 'Tiempo Generado')
				->setCellValue('G1', 'Comentario')
				->setCellValue('H1', 'Fecha')
				->setCellValue('I1', 'Fecha Registro')
				->setCellValue('J1', 'Hora Inicio')
				->setCellValue('K1', 'Hora Final');

	$fila = 2;
	
	while($row_principal = mysqli_fetch_array($consulta_detalle))
	{
	$cadena_persona = "SELECT nombre, ap_paterno, ap_materno FROM empleados WHERE codigo = '$row_principal[1]'";
    $consulta_persona = sqlsrv_query($conn, $cadena_persona);
    $row_persona = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);
    $nombre_empleado = $row_persona['nombre'].' '.$row_persona['ap_paterno'].' '.$row_persona['ap_materno'];
	$empleado = $row_principal[3].' - '.$nombre_empleado;
	
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[3])
	            ->setCellValue('B'.$fila, $row_principal[10])
				->setCellValue('C'.$fila, $row_principal[2])
				->setCellValue('D'.$fila, $row_principal[1])
				->setCellValue('E'.$fila, $nombre_empleado)
				->setCellValue('F'.$fila, $row_principal[5])
				->setCellValue('G'.$fila, $row_principal[6])
				->setCellValue('H'.$fila, $row_principal[7])
				->setCellValue('I'.$fila, $row_principal[8])
				->setCellValue('J'.$fila, $row_principal[11])
				->setCellValue('K'.$fila, $row_principal[12]);
				

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

		$objPHPExcel->getActiveSheet()
    		->getColumnDimension('I')
			->setAutoSize(true);

		$objPHPExcel->getActiveSheet()
    		->getColumnDimension('J')
			->setAutoSize(true);

		$objPHPExcel->getActiveSheet()
    		->getColumnDimension('K')
			->setAutoSize(true);
			
	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Reporte Tiempo Extra');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Tiempo Extra" '.$fecha.' ".xlsx"');
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