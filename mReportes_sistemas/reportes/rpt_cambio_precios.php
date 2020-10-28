<?php 
include("../../global_settings/conexion.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$folio = $_POST['folio'];
$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
// $fecha_inicio = $_POST['fecha_inicial'];
// $fecha_final = $_POST['fecha_final'];
// $sucursal = $_POST['sucursal'];
// $proveedor = $_POST['proveedor'];
// if ($proveedor == ""){
// 	$filtro_proveedor = "";
// }else{
// 	$proveedor = trim($proveedor);
// 	$filtro_proveedor="AND l_a.PROC_CVEPROVEEDOR = '$proveedor'";
// }
// $departamento = $_POST['departamento'];
// if ($departamento == "") {
// 	$filtro_departamento = "";
// }else{
// 	$departamento = trim($departamento);
// 	$filtro_departamento = "AND fs.FAMC_FAMILIAPADRE = '$departamento'";
// }
// $codigo = $_POST['codigo'];
// if ($codigo =="") {
// 	$filtro_codigo = "";
// }else{
// 	$filtro_codigo = "AND articulos.ARTC_ARTICULO = '$codigo'";
// }




$consulta_principal  = "SELECT
							INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO,
							INV_RENGLONES_MOVIMIENTOS.RMOC_UNIMEDIDA,
							INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA,
							INV_RENGLONES_MOVIMIENTOS.RMON_ULTIMOPRECIO,
							INV_RENGLONES_MOVIMIENTOS.RMOC_CVEIVA,
							INV_RENGLONES_MOVIMIENTOS.RMON_IEPS_SN,
							PV_ARTICULOS.ARTC_DESCRIPCION,
							PV_ARTICULOS.ARTN_PRECIOVENTA,
							TO_CHAR( movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD' ) 
						FROM
							INV_RENGLONES_MOVIMIENTOS
							INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN 
							AND INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = movs.MODN_FOLIO 
							AND movs.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
							INNER JOIN PV_ARTICULOS ON PV_ARTICULOS.ARTC_ARTICULO = INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO 
						WHERE
							INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO = '$folio' 
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal' 
							AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = '$tipo'";

							//echo "$consulta_principal";

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
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Fecha entrada anterior')
	            ->setCellValue('D1', 'Fecha Ultima entrada')///////////
	            ->setCellValue('E1', 'Costo entrada anterior')
	            ->setCellValue('F1', 'Costo nueva entrada')
	            ->setCellValue('G1', 'Diferiencia')
                ->setCellValue('H1', 'Cantidad')
                ->setCellValue('I1', 'UM')
                ->setCellValue('J1', 'IVA')
                ->setCellValue('K1', 'IEPS')
                ->setCellValue('L1', 'Precio Venta');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0]);
	            $sel = "SELECT
							* 
						FROM
							(
						SELECT
							detalle.MODN_FOLIO,
							movs.MOVD_FECHAAFECTACION,
							detalle.RMON_ULTIMOPRECIO,
							detalle.ARTC_ARTICULO 
						FROM
							INV_RENGLONES_MOVIMIENTOS detalle
							INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
							AND detalle.MODN_FOLIO = movs.MODN_FOLIO AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV
						WHERE
							ARTC_ARTICULO = '$row_principal[0]' 
							AND movs.ALMN_ALMACEN = '$sucursal'
							AND detalle.ALMN_ALMACEN = '$sucursal'
							AND movs.MOVD_FECHAAFECTACION IS NOT NULL 
							AND movs.MOVD_FECHAAFECTACION < trunc(
							TO_DATE( '$row_principal[8]', 'YYYY-MM-DD' )) 
							AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' ) 
						ORDER BY
							movs.MOVD_FECHAAFECTACION DESC 
							) 
						WHERE
							ROWNUM = 1";
							
				$stat = oci_parse($conexion_central ,$sel);
				oci_execute($stat);
				$row = oci_fetch_row($stat);

			$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[6])	            
	            ->setCellValue('C'.$fila, $row[1])
	            ->setCellValue('D'.$fila, $row_principal[8]);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('E'.$fila, $row[2])
	            ->setCellValue('F'.$fila, $row_principal[3])
	            ->setCellValue('G'.$fila, $row_principal[3] - $row[2]);

		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H'.$fila, $row_principal[2])
                ->setCellValue('I'.$fila, $row_principal[1])
                ->setCellValue('J'.$fila, $row_principal[4])
                ->setCellValue('K'.$fila, $row_principal[5])
                ->setCellValue('L'.$fila, $row_principal[7]);


	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

    	// $objPHPExcel->getActiveSheet()
    	// 	->getColumnDimension('D')
    	// 	->setAutoSize(true);

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
	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Cambio de precios');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Cambio de precios" '.$fecha.' ".xlsx"');
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
