<?php 
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
//$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
//$proveedor = $_POST['proveedor'];
//$codigo = $_POST['codigo'];
//$familia = $_POST['familia'];

// if ($proveedor == "") {
// 	$filtro_proveedor = "";
// }else{
// 	$proveedor = trim($proveedor);
// 	$filtro_proveedor = "AND MOV.MOVC_CVEPROVEEDOR = '$proveedor'";
// }
// if ($codigo == "") {
// 	$filtro_codigo = "";
// }else{
// 	$filtro_codigo = "AND R.ARTC_ARTICULO = '$codigo'";
// }
// if ($familia == "") {
// 	$filtro_familia = "";
// }else{
// 	$filtro_familia = "AND INV.ARTC_FAMILIA = '$familia'";
// }


$consulta_principal  = "SELECT DISTINCT
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
							INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
                            --(SELECT inv.NOMBRE_PROVEEDOR FROM INV_REP_MAR_ESP_COMPRA_VW inv WHERE inv.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1),
							INV_ARTICULOS_DETALLE.ARTN_PRECIO_ULTIMA_COMPRA,
							INV_ARTICULOS_DETALLE.ARTN_PRECIOVENTA,
						    familias.FAMC_DESCRIPCION AS Familia,
                            (
                                SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE
                            ) AS Departamento,
						    (SELECT spin_articulos.fn_existencia_disponible_todos (
							13,
							NULL,
							NULL,
							1,
							1,
							'$sucursal',
							INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						) FROM dual) AS Existencia
						FROM
							INV_ARTICULOS_DETALLE
						INNER JOIN IFZ_INV_DETALLE_MOVIMIENTOS D_M ON D_M.ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO
						INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
						WHERE
							D_M.MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND D_M.MOVD_FECHAAFECTACION < trunc(TO_DATE ('$fecha_final', 'YYYY/MM/DD'))+1
						AND (
							D_M.MODC_TIPOMOV LIKE '%SXM%'
							OR D_M.MODC_TIPOMOV = 'SALXVE'
							OR D_M.MODC_TIPOMOV = 'SIROTA'
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
                ->setCellValue('G1', 'Existencia')
                ->setCellValue('H1', 'Importe de existencia')
                ->setCellValue('I1', 'Ultimo costo')
                ->setCellValue('J1', 'Precio publico');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		$Msucursal = "";
		if ($sucursal == 1) {
			$Msucursal = "Diaz Ordaz";
		}elseif ($sucursal == 2) {
			$Msucursal == "Arboledas";
		}elseif ($sucursal == 3) {
			$Msucursal == "Villegas";
		}elseif($sucursal == 4){
			$Msucursal = "Allende";
		}

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $sucursal);
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
		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G'.$fila, $row_principal[6])
                ->setCellValue('H'.$fila, $row_principal[3] * $row_principal[6])
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
	header('Content-Disposition: attachment;filename="rpt_analisis" '.$fecha.' ".xlsx"');
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
