<?php 
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal_OPE002'];

if($sucursal == 1) {
	$suc = "Diaz Ordaz";
}elseif($sucursal == 2){
	$suc = "Arboledas";
}elseif($sucursal == 3){
	$suc = "Villegas";
}elseif($sucursal == 4){
	$suc = "Allende";
}elseif($sucursal == 5){
	$suc="La Petaca";
}elseif($sucursal == 6){
	$suc="Montemorelos";
}elseif($sucursal == 99){
	$suc="CEDIS";
}



$consulta_principal  = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
							INV_ARTICULOS_DETALLE.ARTN_PRECIO_ULTIMA_COMPRA,
							INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA,
						    familias.FAMC_DESCRIPCION AS Familia,
                            (
                                SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE
                            ) AS Departamento
						FROM
							INV_ARTICULOS_DETALLE
						INNER JOIN IFZ_INV_DETALLE_MOVIMIENTOS D_M ON D_M.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
						WHERE
							D_M.MOVD_FECHAAFECTACION >=  trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND D_M.MOVD_FECHAAFECTACION < trunc(TO_DATE ('$fecha_final', 'YYYY/MM/DD'))+1
						AND (
							D_M.MODC_TIPOMOV LIKE '%SXM%'
						)
						AND D_M.ALMN_ALMACEN = '$sucursal'

						ORDER BY
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO";

	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);


	/** Error reporting */
	error_reporting(E_ALL);
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
	            ->setCellValue('A1', 'Sucursal')
	            ->setCellValue('B1', 'Departamento')
	            ->setCellValue('C1', 'Familia')
	            ->setCellValue('D1', 'Proveedor')
	            ->setCellValue('E1', 'Codigo')
	            ->setCellValue('F1', 'Descripcion')
                ->setCellValue('G1', 'Unidades mermadas')
                ->setCellValue('H1', 'Importe de mermas')
                ->setCellValue('I1', 'Ultimo costo')
                ->setCellValue('J1', 'Precio publico');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $suc);
	            $sel = "SELECT
							PR.PROC_NOMBRE 
						FROM
							COM_ARTICULOSLISTAPRECIOS ART
							INNER JOIN CXP_PROVEEDORES PR ON TRIM(PR.PROC_CVEPROVEEDOR) = TRIM(ART.PROC_CVEPROVEEDOR)
						WHERE
							ART.ARTC_ARTICULO = '$row_principal[0]' 
							AND ROWNUM = 1";
							
				$stat = oci_parse($conexion_central ,$sel);
				oci_execute($stat);
				$prov = oci_fetch_row($stat);

				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[5])	            
	            ->setCellValue('C'.$fila, $row_principal[4]);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('D'.$fila, $prov[0])
	            ->setCellValue('E'.$fila, $row_principal[0])
	            ->setCellValue('F'.$fila, $row_principal[1]);

	            $smermas = "SELECT
							SUM(D_M.CRMN_CANTIDAD_UMR)
						FROM
							IFZ_INV_DETALLE_MOVIMIENTOS D_M 
						WHERE
							D_M.ARTC_ARTICULO = '$row_principal[0]' 
							AND D_M.ALMN_ALMACEN = '$sucursal' 
							AND D_M.MOVD_FECHAAFECTACION >= TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' ) 
							AND D_M.MOVD_FECHAAFECTACION <= TO_DATE( '$fecha_final', 'YYYY/MM/DD' ) 
							AND D_M.MODC_TIPOMOV LIKE '%SXM%' 
						AND D_M.ALMN_ALMACEN = '$sucursal'";
				$stat2 = oci_parse($conexion_central, $smermas);
				oci_execute($stat2);
				$row_merma = oci_fetch_row($stat2);
		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G'.$fila, $row_merma[0])
                ->setCellValue('H'.$fila, $row_principal[3] * $row_merma[0])
                ->setCellValue('I'.$fila, $row_principal[2])
                ->setCellValue('J'.$fila, $row_principal[3]);


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
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reporte_Mermas_' .$fecha. '.xlsx"');
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
