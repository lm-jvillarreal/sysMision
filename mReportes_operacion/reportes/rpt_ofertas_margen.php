<?php 
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];
$proveedor = $_POST['proveedor'];
if ($proveedor == ""){
	$filtro_proveedor = "";
}else{
	$proveedor = trim($proveedor);
	$filtro_proveedor="AND l_a.PROC_CVEPROVEEDOR = '$proveedor'";
}
$departamento = $_POST['departamento'];
if ($departamento == "") {
	$filtro_departamento = "";
}else{
	$departamento = trim($departamento);
	$filtro_departamento = "AND fs.FAMC_FAMILIAPADRE = '$departamento'";
}
$codigo = $_POST['codigo'];
if ($codigo =="") {
	$filtro_codigo = "";
}else{
	$filtro_codigo = "AND articulos.ARTC_ARTICULO = '$codigo'";
}




$consulta_principal  = "SELECT DISTINCT
							ARTICULOS.ARTC_ARTICULO,
							ARTICULOS.ARTC_DESCRIPCION_LARGA,
							ARTICULOS.ARTC_CODIGOBARRAS,
							ARTICULOS.ARTN_PRECIOVENTA,
							A_O.ARON_PORCDESCUENTOOPRECIO,
							CONF.COOD_VIGENCIA_FIN,
							articulos.ARTN_COSTO_PROMEDIO,
							articulos.ARTN_PRECIO_ULTIMA_COMPRA,
							CONF.COON_TIPO,
							articulos.artc_familia AS familia,
							( SELECT fam.FAMC_DESCRIPCION FROM COM_FAMILIAS fam WHERE fam.FAMC_FAMILIA = fs.FAMC_FAMILIAPADRE ),
							a_o.AROC_SUCURSAL,
							ARTICULOS.ARTN_PCT_IMPUESTO1,
							ARTICULOS.ARTN_PCT_IMPUESTO2 
						FROM
							INV_ARTICULOS_DETALLE articulos
							INNER JOIN PV_ARTICULOS_OFERTA a_o ON A_O.AROC_ARTICULO = ARTICULOS.ARTC_CODIGOBARRAS
							INNER JOIN PV_CONFIGURACION_OFERTA CONF ON CONF.COON_ID_OFERTA = A_O.COON_ID_OFERTA
							INNER JOIN COM_ARTICULOSLISTAPRECIOS l_a ON trim( l_a.ARTC_ARTICULO ) = trim( A_O.AROC_ARTICULO )
							INNER JOIN COM_FAMILIAS FS ON fs.FAMC_FAMILIA = articulos.artc_familia 
						WHERE
							a_o.AROC_SUCURSAL = '$sucursal'
							AND CONF.COOD_VIGENCIA_FIN >= trunc(TO_DATE( '$fecha', 'YYYY-MM-DD' )) 
							".$filtro_proveedor.$filtro_codigo.$filtro_departamento." 
							

							 
							
						ORDER BY
							conf.COOD_VIGENCIA_FIN DESC";

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
	            ->setCellValue('A1', 'Sucursal')
	            ->setCellValue('B1', 'Codigo')
	            ->setCellValue('C1', 'Descripcion')
	            ->setCellValue('D1', 'Ultimo costo')
	            ->setCellValue('E1', 'Costo promedio')
	            ->setCellValue('F1', 'Precio venta')
                ->setCellValue('G1', 'Margen neto')
                ->setCellValue('H1', 'Precio oferta')
                ->setCellValue('I1', 'Margen con oferta')
                ->setCellValue('J1', 'Vigencia oferta');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
			if ($row_principal[12] == 0) {
				$precio_imp = $row_principal[3] + ($row_principal[3] * $row_principal[13]);
			}else{
				$precio_imp = $row_principal[3] + ($row_principal[3] * $row_principal[12]);
			}

			if ($row_principal[8] == 0) {
				//descuento
				$var = $row_principal[4] * .01;
				$desc = $row_principal[3] * $var;
				$precio_final = $row_principal[3] - $desc;

			}else{
				//precio fijo
				
				$precio_final = $row_principal[4];
			}

			if ($precio_final == 0) {
				$margen_oferta = 0;
			}else{
				$margen_oferta = (1-($row_principal[7] / $precio_final))*100;
			}

			$margen = (1-($row_principal[7] / $row_principal[3]))*100;
			
			
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, "");
	     //        $sel = "SELECT
						// 	PR.PROC_NOMBRE 
						// FROM
						// 	COM_ARTICULOSLISTAPRECIOS ART
						// 	INNER JOIN CXP_PROVEEDORES PR ON TRIM(PR.PROC_CVEPROVEEDOR) = TRIM(ART.PROC_CVEPROVEEDOR)
						// WHERE
						// 	ART.ARTC_ARTICULO = '$row_principal[0]' 
						// 	AND ROWNUM = 1";
							
				// $stat = oci_parse($conexion_central ,$sel);
				// oci_execute($stat);
				// $prov = oci_fetch_row($stat);

				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[0])	            
	            ->setCellValue('C'.$fila, $row_principal[1]);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('D'.$fila, $row_principal[7])
	            ->setCellValue('E'.$fila, $row_principal[6])
	            ->setCellValue('F'.$fila, round($precio_imp,2));


		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G'.$fila, $margen)
                ->setCellValue('H'.$fila, $precio_final)
                ->setCellValue('I'.$fila, $margen_oferta)
                ->setCellValue('J'.$fila, $row_principal[5]);


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
	$objPHPExcel->getActiveSheet()->setTitle('Ofertas');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="reporte ofertas" '.$fecha.' ".xlsx"');
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
