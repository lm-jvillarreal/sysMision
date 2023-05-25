<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_final = $_POST['fecha_final'];
$fecha_fin=str_replace("-","",$fecha_final);
$sucursal = $_POST['sucursal_OPE006'];
//$familia = $_POST['familia'];
$f_inicio = new DateTime($fecha_inicio);
$f_fin = new DateTime($fecha_final);
$diff = $f_inicio->diff($f_fin);
$dias = $diff->days;
$dias = $dias +1;
$proveedor = $_POST['proveedor_OPE006'];
$proveedor = trim($proveedor);

$array = $_POST['array'];
$arra = explode(',', $array);
$or="";
if ($proveedor == "") {
	$cantidad = count($arra);
	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
	$where = " WHERE
			(
				INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$arra[0]'".$or."
			) ";
}else{
	$where=" WHERE lista.PROC_CVEPROVEEDOR = '$proveedor'";
}




$consulta_principal  = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
							INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
							familias.FAMC_DESCRIPCION AS Familia,
							(
								SELECT
									PROC_CVEPROVEEDOR
								FROM
									COM_ARTICULOSLISTAPRECIOS
								WHERE
									INV_ARTICULOS_DETALLE.ARTC_ARTICULO = COM_ARTICULOSLISTAPRECIOS.ARTC_ARTICULO
								AND ROWNUM = 1
							),
							( SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
							( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$sucursal', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia,
							ROUND( INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2 ) 
						FROM
							INV_ARTICULOS_DETALLE
							INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
							INNER JOIN COM_ARTICULOSLISTAPRECIOS LISTA ON LISTA.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO".$where."
						ORDER BY
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO";
						 //echo "$consulta_principal";
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

	    function cellColor($cells,$color){ 
        global $objPHPExcel; 
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill('') 
        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 
        'startcolor' => array('rgb' => $color) 
        )); 
    } 

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
	            ->setCellValue('C1', 'Departamento')
	            ->setCellValue('D1', 'Familia')
	            ->setCellValue('E1', 'Ultimo costo')
	            ->setCellValue('F1', 'Ventas')
				->setCellValue('G1', 'Existencias')
				->setCellValue('H1', 'Faltante')
				->setCellValue('I1', 'Dias de inventario');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])	            
	            ->setCellValue('C'.$fila, $row_principal[5])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, $row_principal[2]);
	            $smermas = "SELECT
								SUM (DETALLE.ARTN_CANTIDAD)
							FROM
								PV_ARTICULOSTICKET detalle
							INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
							AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
							WHERE
								DETALLE.ARTC_ARTICULO = '$row_principal[0]'
							AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
							AND '$fecha_fin'
							AND TIK.TICC_SUCURSAL = '$sucursal'
							AND DETALLE.TICC_SUCURSAL = '$sucursal'
							AND TIK.TICN_ESTATUS = 3";
				$stat2 = oci_parse($conexion_central, $smermas);
				oci_execute($stat2);

				$row_merma = oci_fetch_row($stat2);
				$faltante = $row_merma[0] - $row_principal[6]; //faltante = ventas - existencias
				if (empty($row_merma[0])) {
					$dias_inventario = "";
				}else{
					$dias_inventario = $row_principal[6]/($row_merma[0]/$dias);//existencias/(ventas/dias)	
				}

				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('F'.$fila, $row_merma[0])
	            ->setCellValue('G'.$fila, $row_principal[6])
	            ->setCellValue('H'.$fila, $faltante)
	            ->setCellValue('I'.$fila, $dias_inventario);

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

	$fila = 2;
	oci_execute($stmt);
	while ($row_2 = oci_fetch_row($stmt)) {
		$objPHPExcel ->setActiveSheetIndex(0);
		$c_i = $objPHPExcel->getActiveSheet()->getCell('I' . $fila)->getCalculatedValue();
		$c_h = $objPHPExcel->getActiveSheet()->getCell('H' . $fila)->getCalculatedValue();
		if ($c_i < 10) {
			cellColor('I'.$fila, 'F28A8C');
		}
		if ($c_h > 0) {
			cellColor('H'.$fila, 'F28A8C');
		}
		$fila = $fila +1;
	}



	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Dias de inventario');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="dias de inventario" '.$fecha.' ".xlsx"');
	header('Content-Disposition: attachment;filename="Dias_de_inventario_' .$fecha. '.xlsx"');

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
