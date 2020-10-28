<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
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
$array = $_POST['array_devoluciones'];

$arra = explode(',', $array);


if ($proveedor == "") {

	$cantidad = count($arra);
	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR R.ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}
	$where = " WHERE (R.ARTC_ARTICULO = '$arra[0]'".$or.")";
	$filtro_proveedor = "";

}else{
	$proveedor = trim($proveedor);
	$where = " WHERE MOV.MOVC_CVEPROVEEDOR = '$proveedor'";
}
if ($codigo == "") {
	$filtro_codigo = "";
}else{
	$filtro_codigo = "AND R.ARTC_ARTICULO = '$codigo'";
}

$consulta_principal  = "SELECT
							R.MODN_FOLIO,
							MOV.MOVD_FECHAAFECTACION,
							MOV.MOVD_FECHAELABORACION,
							R.ARTC_ARTICULO,
							art.artc_descripcion,
							lista.alpn_precio,
							R.MODC_TIPOMOV,
							MOV.MOVC_REFERENCIA,
							R.RMOC_UNIMEDIDA,
							R.RMON_CANTSURTIDA,
							R.RMON_COSTO_RENGLON_MB,
							art.artn_precioventa,
							MOV.MOVC_CVEPROVEEDOR,
							CVE.PROC_CLAVE,
							MOV.MOVC_COMENTARIOS
						FROM
							INV_RENGLONES_MOVIMIENTOS R
						INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = r.MODN_FOLIO
						AND MOV.MODC_TIPOMOV = R.MODC_TIPOMOV
						AND MOV.ALMN_ALMACEN = R.ALMN_ALMACEN
						INNER JOIN COM_ARTICULOS art ON art.artc_codigobarras = r.artc_articulo
						INNER JOIN COM_ARTICULOSLISTAPRECIOS lista ON lista.ARTC_ARTICULO = R.ARTC_ARTICULO AND lista.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
						INNER JOIN INV_REP_MAR_ESP_COMPRA_VW invs ON invs.proc_cveproveedor = MOV.MOVC_CVEPROVEEDOR
						AND invs.ARTC_ARTICULO = R.ARTC_ARTICULO
						LEFT JOIN INV_CLAVEPROVEEDOR CVE ON CVE.ARTC_ARTICULO = R.ARTC_ARTICULO".$where."

						AND
							R.MODC_TIPOMOV = '$tipo'
						AND MOV.MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND MOV.MOVD_FECHAAFECTACION < trunc(TO_DATE ('$fecha_final', 'YYYY/MM/DD'))+1
						AND r.ALMN_ALMACEN = '$sucursal'
						AND MOV.MODC_TIPOMOV = '$tipo'
						GROUP BY
							R.ARTC_ARTICULO,
							R.MODN_FOLIO,
							MOV.MOVD_FECHAAFECTACION,
							MOV.MOVD_FECHAELABORACION,
							R.MODC_TIPOMOV,
							MOV.MOVC_REFERENCIA,
							R.RMOC_UNIMEDIDA,
							R.RMON_CANTSURTIDA,
							R.RMON_COSTO_RENGLON_MB,
							art.artc_descripcion,
							art.artn_precioventa,
							lista.alpn_precio,
							lista.proc_cveproveedor,
							MOV.MOVC_CVEPROVEEDOR,
							CVE.PROC_CLAVE,
							MOV.MOVC_COMENTARIOS
						ORDER BY
							R.MODN_FOLIO";
							//echo "$consulta_principal";





	//$resultado_principal=mysql_query ($consulta_principal, $conexion) or die (mysql_error());
	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);



//$registros = mysql_num_rows ($resultado_principal);
	
	
	
	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 300); 
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
	$objPHPExcel->getProperties()->setCreator("Antonio Martinez")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Devoluciónes")
								 ->setDescription("Reporte de las Devoluciónes")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Folio')
	            ->setCellValue('B1', 'Tipo Dev')
	            ->setCellValue('C1', 'Comentarios')
	            ->setCellValue('D1', 'Nota de ent')
	            ->setCellValue('E1', 'Fecha de devolucion')
	            ->setCellValue('F1', 'No. de proveedor')
                ->setCellValue('G1', 'Art. prov')
                ->setCellValue('H1', 'Articulo')
                ->setCellValue('I1', 'Descripcion')
                ->setCellValue('J1', 'UM')
                ->setCellValue('K1', 'Cant')
                ->setCellValue('L1', 'Costo unitario')
                ->setCellValue('M1', 'Importe')
                ->setCellValue('N1', 'Fol. Ent')
                ->setCellValue('O1', 'Tipo Mov')
                ->setCellValue('P1', 'Factura')
                ->setCellValue('Q1', 'Fecha Entrada');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{
		if (is_null($row_principal[9])) {
			$row_principal[9] = 1;
		}
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[6])
	            ->setCellValue('C'.$fila, $row_principal[14])
	            ->setCellValue('D'.$fila, $row_principal[7])
	            ->setCellValue('E'.$fila, $row_principal[1])
	            ->setCellValue('F'.$fila, $row_principal[12]) 
                ->setCellValue('G'.$fila, $row_principal[13])
                ->setCellValue('H'.$fila, $row_principal[3])
                ->setCellValue('I'.$fila, $row_principal[4])
                ->setCellValue('J'.$fila, $row_principal[8])
                ->setCellValue('K'.$fila, $row_principal[9])
                ->setCellValue('L'.$fila, $row_principal[10]/$row_principal[9])
                ->setCellValue('M'.$fila, $row_principal[10]);


                if ($tipo == "DMPROV") {
                	$AND = "AND MOV.MOVC_NOTAENTRADA = '$row_principal[7]'";
                }elseif ($tipo =="DEVPRO" || $tipo=="DEVXCO") {
                	$valor = strlen($row_principal[7]); 
                	if ($valor > 6) {
	                	$cadena = $row_principal[7];
	                	$sinletras = substr($cadena, 6);
	                	$AND = "AND MOV.MODN_FOLIO = '$sinletras'";
                	}else{
                		$AND = "AND MOV.MODN_FOLIO = '$row_principal[7]'";
                	}

                }

                $qry2 = "SELECT
							R.MODN_FOLIO,
						    MOV.MODN_FOLIO,
						    MOV.MODC_TIPOMOV,
						    MOV.MOVC_CXP_REMISION,
						    MOV.MOVD_FECHAAFECTACION
						FROM
							INV_RENGLONES_MOVIMIENTOS R
						INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
						WHERE
							(R.MODC_TIPOMOV = 'ENTCOC' OR R.MODC_TIPOMOV = 'ENTSOC')
						AND (MOV.MODC_TIPOMOV = 'ENTCOC'  OR MOV.MODC_TIPOMOV = 'ENTSOC')".$AND."
						AND r.ALMN_ALMACEN = '$sucursal'
						AND MOV.ALMN_ALMACEN = '$sucursal'
						AND rownum <= 1
						GROUP BY 	
						R.MODN_FOLIO,
						    MOV.MODN_FOLIO,
						    MOV.MODC_TIPOMOV,
						    MOV.MOVC_CXP_REMISION,
						    MOV.MOVD_FECHAAFECTACION";

		    	$stmt2 = oci_parse($conexion_central, $qry2);
				oci_execute($stmt2);
				$row = oci_fetch_row($stmt2);
				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('N'.$fila, $row[0])
	            ->setCellValue('O'.$fila, $row[2])
	            ->setCellValue('P'.$fila, $row[3])
	            ->setCellValue('Q'.$fila, $row[4]);


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
        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('P')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('Q')
        ->setAutoSize(true);

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Devoluciónes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Devoluciónes" '.$fecha.' ".xlsx"');
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
