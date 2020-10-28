<?php 
include("../../global_settings/conexion.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];
$departamento = $_POST['departamento'];
$variable = $_POST['jObject'];
$array = $_POST['array'];

$arra = explode(',', $array);

// $proveedor = $_POST['proveedor'];
// if ($proveedor == ""){
// 	$filtro_proveedor = "";
// }else{
// 	$proveedor = trim($proveedor);
// 	$filtro_proveedor="AND l_a.PROC_CVEPROVEEDOR = '$proveedor'";
// }
// $departamento = $_POST['departamento'];
if ($departamento == "") {
		$cantidad = count($arra);
	

	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
	$where = " WHERE
	(
		INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[0]'".$or."
	)";
}else{
	$departamento = trim($departamento);
	$where = " WHERE familias.FAMC_FAMILIAPADRE = '$departamento'";
}
// $codigo = $_POST['codigo'];
// if ($codigo =="") {
// 	$filtro_codigo = "";
// }else{
// 	$filtro_codigo = "AND articulos.ARTC_ARTICULO = '$codigo'";
// }



$consulta_principal = "SELECT DISTINCT
	INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
	INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
	INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA,
	familias.FAMC_DESCRIPCION AS Familia,
	INV_ARTICULOS_DETALLE.ARTN_PCT_IVA,
	INV_ARTICULOS_DETALLE.ARTN_PCT_IEPS,
	INV_ARTICULOS_DETALLE.ARTC_UNIMEDIDA_COMPRA
FROM
	INV_ARTICULOS_DETALLE
INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
INNER JOIN COM_ARTICULOS ON COM_ARTICULOS.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO".$where."

AND COM_ARTICULOS.ARTN_ESTATUS = '1'
AND INV_ARTICULOS_DETALLE.ARTC_ARTICULO NOT LIKE '%G%'
ORDER BY
	INV_ARTICULOS_DETALLE.ARTC_ARTICULO";
	

	 // echo "$consulta_principal";

// $consulta_principal  = "SELECT DISTINCT
// 							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
// 							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
// 							INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA,
// 							familias.FAMC_DESCRIPCION AS Familia,
// 							INV_ARTICULOS_DETALLE.ARTN_PCT_IVA,
// 							INV_ARTICULOS_DETALLE.ARTN_PCT_IEPS,
// 							INV_ARTICULOS_DETALLE.ARTC_UNIMEDIDA_COMPRA
// 						FROM
// 							INV_ARTICULOS_DETALLE
// 							INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA --AND familias.FAMC_FAMILIAPADRE = '02'--AND (INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '751' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '244' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '200' OR INV_ARTICULOS_DETALLE.ARTC_FAMILIA = '209')
// 							INNER JOIN COM_ARTICULOS ON COM_ARTICULOS.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
							
// 							AND familias.FAMC_FAMILIAPADRE = '$departamento'
// 							AND COM_ARTICULOS.ARTN_ESTATUS = '1'
// 							AND INV_ARTICULOS_DETALLE.ARTC_ARTICULO NOT LIKE '%G%'
// 						ORDER BY
// 							INV_ARTICULOS_DETALLE.ARTC_ARTICULO";

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
	            ->setCellValue('C1', 'Fecha penultima entrada')
	            ->setCellValue('D1', 'Fecha ultima entrada')
	            ->setCellValue('E1', 'Costo penultima entrada')
	            ->setCellValue('F1', 'Costo ultima entrada')
                ->setCellValue('G1', 'Diferencia')
                ->setCellValue('H1', 'Cantidad ultima entrada')
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
							TO_CHAR(movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD'),
							detalle.RMON_ULTIMOPRECIO,
							detalle.ARTC_ARTICULO,
							detalle.RMON_CANTSURTIDA,
							detalle.RMOC_UNIMEDIDA 
						FROM
							INV_RENGLONES_MOVIMIENTOS detalle
							INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
							AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
							AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
						WHERE
							ARTC_ARTICULO = '$row_principal[0]' 
							AND movs.ALMN_ALMACEN = '$sucursal' 
							AND detalle.ALMN_ALMACEN = '$sucursal' 
							AND movs.MOVD_FECHAAFECTACION IS NOT NULL 
							AND movs.MOVD_FECHAAFECTACION <= trunc(TO_DATE( '$fecha', 'YYYY-MM-DD' ))+1
							AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' ) 
						ORDER BY
							movs.MOVD_FECHAAFECTACION DESC 
							) 
						WHERE
							ROWNUM <= 1";
							
				$stat = oci_parse($conexion_central ,$sel);
				oci_execute($stat);
				$row = oci_fetch_row($stat);
				$sel2 = "SELECT
							* 
						FROM
							(
						SELECT
							detalle.MODN_FOLIO,
							TO_CHAR(movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD'),
							detalle.RMON_ULTIMOPRECIO,
							detalle.ARTC_ARTICULO,
							detalle.RMON_CANTSURTIDA,
							detalle.RMOC_UNIMEDIDA 
						FROM
							INV_RENGLONES_MOVIMIENTOS detalle
							INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
							AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
							AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
						WHERE
							ARTC_ARTICULO = '$row_principal[0]' 
							AND movs.ALMN_ALMACEN = '$sucursal' 
							AND detalle.ALMN_ALMACEN = '$sucursal' 
							AND movs.MOVD_FECHAAFECTACION IS NOT NULL 
							AND movs.MOVD_FECHAAFECTACION <= trunc(TO_DATE( '$row[1]', 'YYYY-MM-DD' )) 
							AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' ) 
						ORDER BY
							movs.MOVD_FECHAAFECTACION DESC 
							) 
						WHERE
							ROWNUM <= 1";
				$stat2=oci_parse($conexion_central, $sel2);
				oci_execute($stat2);
				$row2 = oci_fetch_row($stat2);


				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row2[1]);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('D'.$fila, $row[1])
	            ->setCellValue('E'.$fila, $row2[2])
	            ->setCellValue('F'.$fila, $row[2]);


		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G'.$fila, $row[2] - $row2[2])
                ->setCellValue('H'.$fila, $row[4])
                ->setCellValue('I'.$fila, $row_principal[6])
                ->setCellValue('J'.$fila, $row_principal[4])
                ->setCellValue('K'.$fila, $row_principal[5])
                ->setCellValue('L'.$fila, $row_principal[2]);


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
