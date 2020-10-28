<?php
//Incluimos la conexión a la BD de InfoFIN
include("../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio =  str_replace("-","",$_POST['fecha_inicial']);
$fecha_fin = str_replace("-","",$_POST['fecha_final']);
$estatus = $_POST['estatus'];

$fecha_ini = $_POST['fecha_inicial'];
$fecha_fn = $_POST['fecha_final'];

$filtro = '';

if ($estatus=='1') {
	$filtro = 'IS NULL';
} elseif ( $estatus == '2' ){
	$filtro = 'IS NOT NULL';
}

$cadena_consulta  = "
SELECT A.PROC_CVEPROVEEDOR \"CveProveedor\", A.PROC_NOMBRE \"Proveedor\", TF.TABC_DESCRIPCION \"Tipo de Factura\",
       B.NCCV_NUMNCC \"Nota Crédito\", B.NCCN_TIPO \"Tipo NC\", B.NCCD_FECHANCC \"Fecha\",--B.NCCC_NUMFACT,
       B.NCCN_ESTATUS \"Status\", B.nccv_referencia \"Referencia\", TRIM(SUBSTR(B.NCCV_DESCRIPCION,1,200)) || 
     DECODE (B.NCCN_ESTATUS,0,' (Capturada)',
                              1, DECODE( B.NCCC_NUMFACT, NULL, ' (Autorizada Sin Asignar)'
                                                             , ' (Autorizada y Asignada)')
                               , ' (ESTATUS NO IDENTIFICADO)') \"Descripción\",
       E.TABC_DESCRIPCION  \"Moneda\", B.NCCN_IMPORTE / NCCF_TCAMBIO \"Importe\", B.NCCN_IVA / NCCF_TCAMBIO \"IVA\",
       B.NCCN_IEPS / NCCF_TCAMBIO ieps, B.NCCN_RETENCION / NCCF_TCAMBIO \"Retención\",
      (B.NCCN_IMPORTE + B.NCCN_IVA + NVL(B.NCCN_IEPS,0) - B.NCCN_RETENCION) / NCCF_TCAMBIO \"Total\"
       --, inv.MODN_folio
       , inv.ALMN_ALMACEN \"Almacén\", inv.MODC_TIPOMOV || '-' || 
        DECODE(inv.MODC_TIPOMOV,'ENTCOC',inv.movc_notaentrada,'ENTSOC',inv.MODN_folio) as  \"Folio Entrada\"
      , (select modc_tipomov || '-' || MODN_folio 
         from inv_movimientos
         where ctbs_cia = A.CTBS_CIA
         and rtrim(movc_cveproveedor) = rtrim(B.PROC_CVEPROVEEDOR)
         and rtrim(movc_cxp_remision) = rtrim(b.nccv_numncc)) \"Folio Salida\"
FROM  CXP_PROVEEDORES A,
     CXP_NOTASCARCRE B,
     CTB_TABCON E,
     CTB_TABCON TF,
      INV_MOVIMIENTOS inv
WHERE  A.CTBS_CIA = 1 AND
        A.CTBS_CIA = B.CTBS_CIA AND 
       A.CTBS_CIA = E.CTBS_CIA AND
        A.PROC_CVEPROVEEDOR = B.PROC_CVEPROVEEDOR and 
        inv.ctbs_cia = A.CTBS_CIA and 
        rtrim(inv.movc_cveproveedor) = rtrim(B.PROC_CVEPROVEEDOR) and 
        rtrim(inv.movc_cxp_remision) = rtrim(B.nccv_referencia)
  /*************  S E C C I Ó N   D E   F I L T R O S  ***************/
        AND to_char(B.NCCD_FECHANCC, 'YYYYMMDD') BETWEEN '$fecha_inicio'  -- Fecha Inicial formato AAAAMMDD
                                                     AND '$fecha_fin'  -- Fecha Final formato AAAAMMDD 
  /***F**I**N***  S E C C I Ó N   D E   F I L T R O S  ***************/
        AND E.TABS_NUMTABLA = 1 AND
       B.NCCC_MONEDA = E.TABC_ELEMENTO AND
       TF.CTBS_CIA = B.CTBS_CIA AND
        TF.TABS_NUMTABLA = 102 AND
        B.NCCC_TIPOFACT = TF.TABC_ELEMENTO
        and B.NCCC_NUMFACT $filtro                               -- Solo Pendientes de Asignar:(Factura = null)
ORDER BY
        A.PROC_CVEPROVEEDOR,
        B.NCCC_MONEDA,
        B.NCCV_NUMNCC,
        B.NCCC_NUMFACT
";
							
							//echo "$cadena_consulta";
$consulta_principal = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_principal);

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
	$objPHPExcel->getProperties()->setCreator("Josué Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte detalle de compras")
								 ->setSubject("Reporte de compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Cve.Prov')
	            ->setCellValue('B1', 'Proveedor')
	            ->setCellValue('C1', 'Tipo de Factura')
	            ->setCellValue('D1', 'Nota Crédito')
	            ->setCellValue('E1', 'Tipo NC')
	            ->setCellValue('F1', 'Fecha')
                ->setCellValue('G1', 'Status')
                ->setCellValue('H1', 'Referencia')
                ->setCellValue('I1', 'Descripción')
                ->setCellValue('J1', 'Moneda')
                ->setCellValue('K1', 'Importe')
                ->setCellValue('L1', 'IVA')
                ->setCellValue('M1', 'IEPS')
                ->setCellValue('N1', 'Retención')
                ->setCellValue('O1', 'Total')
                ->setCellValue('P1', 'Almacén')
                ->setCellValue('Q1', 'Folio entrada')
                ->setCellValue('R1', 'Folio Salida');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{
		$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$fila, $row_principal[0])
								->setCellValue('B'.$fila, $row_principal[1])
								->setCellValue('C'.$fila, $row_principal[2])
								->setCellValue('D'.$fila, $row_principal[3])
								->setCellValue('E'.$fila, $row_principal[4])
								->setCellValue('F'.$fila, $row_principal[5])
                ->setCellValue('G'.$fila, $row_principal[6])
                ->setCellValue('H'.$fila, $row_principal[7])
                ->setCellValue('I'.$fila, $row_principal[8])
                ->setCellValue('J'.$fila, $row_principal[9])
                ->setCellValue('K'.$fila, $row_principal[10])
                ->setCellValue('L'.$fila, $row_principal[11])
                ->setCellValue('M'.$fila, $row_principal[12])
                ->setCellValue('N'.$fila, $row_principal[13])
                ->setCellValue('O'.$fila, $row_principal[14])
                ->setCellValue('P'.$fila, $row_principal[15])
                ->setCellValue('Q'.$fila, $row_principal[16])
                ->setCellValue('R'.$fila, $row_principal[17]);



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

    	$objPHPExcel->getActiveSheet()
        	->getColumnDimension('R')
        	->setAutoSize(true);

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Notas de Crédito');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="NC_'.$fecha_inicio.'-'.$fecha_fin.'.xlsx"');
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
