<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../../global_settings/conexion_oracle.php");
//include("conexion.php");
date_default_timezone_set('America/Monterrey');

//Descargamos, creamos e inicializamos las variables de uso Local
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];
$sucursal = $_POST['sucursal_COM001'];
$codigo_producto = $_POST['codigo_producto'];
$proveedor = $_POST['proveedor_COM001'];
$departamento = $_POST['departamento_COM001'];
$tipo = $_POST['tipo_entrada_COM001'];

//Filtro para evaluar el tipo de entrada
if ($tipo == "ENTSOC") {
	$ONN = " ON INV_MOVIMIENTOS.MODN_FOLIO = INV_REP_MAR_ESP_COMPRA_VW.ENTN_ENTRADA";
}elseif($tipo=="ENTCOC"){
	$ONN = " ON INV_MOVIMIENTOS.MOVC_NOTAENTRADA= INV_REP_MAR_ESP_COMPRA_VW.ENTN_ENTRADA";
}

//Filtro que aplica para el proveedor
if ($proveedor == "") {
	$filtro_proveedor = "";
}else{
	$proveedor = trim($proveedor);
	$filtro_proveedor = " AND INV_REP_MAR_ESP_COMPRA_VW.PROC_CVEPROVEEDOR = '$proveedor' AND INV_MOVIMIENTOS.MOVC_CVEPROVEEDOR = '$proveedor'";
}

//Filtro para el código de producto
if ($codigo_producto == "") {
	$filtro_codigo = "";
}else{
	$filtro_codigo = " AND INV_REP_MAR_ESP_COMPRA_VW.ARTC_ARTICULO = '$codigo_producto'";
}

//Filtro para el departamento
if ($departamento == "") {
	$filtro_departamento = "";
}else{
	$filtro_departamento = " AND COM_FAMILIAS.FAMC_FAMILIAPADRE = '$departamento'";
}


$cadena_consulta  = "SELECT INV_MOVIMIENTOS.ALMN_ALMACEN,
							TO_CHAR(INV_MOVIMIENTOS.MOVD_FECHAAFECTACION,'DD/MM/YYYY'),
							INV_MOVIMIENTOS.MOVC_CVEPROVEEDOR,
							INV_REP_MAR_ESP_COMPRA_VW.NOMBRE_PROVEEDOR,
							INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO,
							INV_REP_MAR_ESP_COMPRA_VW.ARTC_DESCRIPCION,
							COM_FAMILIAS.FAMC_DESCRIPCION,
							INV_RENGLONES_MOVIMIENTOS.RMOC_UNIMEDIDA,
							INV_REP_MAR_ESP_COMPRA_VW.ROCN_DESCTO_ESPECIE,
							INV_REP_MAR_ESP_COMPRA_VW.CANTIDAD,
							ROUND(INV_REP_MAR_ESP_COMPRA_VW.COSTO_UNITARIO,2),
							ROUND(INV_REP_MAR_ESP_COMPRA_VW.TOTAL_COSTO,2),
							INV_RENGLONES_MOVIMIENTOS.RMOC_CVEIVA,
							INV_RENGLONES_MOVIMIENTOS.RMOC_CVEIEPS,
							ROUND(INV_REP_MAR_ESP_COMPRA_VW.PCT_UTILIDAD_LP,2),
							INV_MOVIMIENTOS.MODN_FOLIO,
							INV_MOVIMIENTOS.MODC_TIPOMOV,
							INV_MOVIMIENTOS.MOVC_CXP_REMISION
							FROM INV_MOVIMIENTOS
							INNER JOIN INV_RENGLONES_MOVIMIENTOS
							ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
							INNER JOIN INV_REP_MAR_ESP_COMPRA_VW
							".$ONN."
							INNER JOIN COM_FAMILIAS
							ON INV_REP_MAR_ESP_COMPRA_VW.ARTC_FAMILIA = COM_FAMILIAS.FAMC_FAMILIA
							AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = INV_REP_MAR_ESP_COMPRA_VW.ARTC_ARTICULO
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
							AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION < TRUNC(TO_DATE('$fecha_fin','YYYY-MM-DD'))+1
							AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
							AND INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = '$sucursal'
							".$filtro_proveedor."
							AND INV_MOVIMIENTOS.MODC_TIPOMOV = '$tipo'
							AND INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = '$tipo'
							".$filtro_departamento.$filtro_codigo."
							ORDER BY INV_REP_MAR_ESP_COMPRA_VW.ARTC_DESCRIPCION ASC";
							
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
	require_once '../../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte detalle de compras")
								 ->setSubject("Reporte de compras")
								 ->setDescription("Reporte de compras")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Sucursal')
	            ->setCellValue('B1', 'Fecha de entrada')
	            ->setCellValue('C1', 'Clave proveedor')
	            ->setCellValue('D1', 'Nombre del proveedor')
	            ->setCellValue('E1', 'Articulo')
	            ->setCellValue('F1', 'Descripcion')
                ->setCellValue('G1', 'Departamento')
                ->setCellValue('H1', 'Familia')
                ->setCellValue('I1', 'UM compra')
                ->setCellValue('J1', 'Decto. en especie')
                ->setCellValue('K1', 'Cantidad')
                ->setCellValue('L1', 'Costo Unitario')
                ->setCellValue('M1', 'Costo total')
                ->setCellValue('N1', 'IVA Compra')
                ->setCellValue('O1', 'IEPS compra')
                ->setCellValue('P1', 'Margen real')
                ->setCellValue('Q1', 'Movimiento')
                ->setCellValue('R1', 'Tipo entrada')
                ->setCellValue('S1', 'Factura/Remision');


	$fila = 2;
	while($row_principal = oci_fetch_row($consulta_principal))
	{
		if ($row_principal[0] == 1) {
			$Msucursal = "Diaz Ordaz";
		}elseif ($row_principal[0] == 2) {
			$Msucursal = "Arboledas";
		}elseif ($row_principal[0] == 3) {
			$Msucursal = "Villegas";
		}elseif($row_principal[0] == 4){
			$Msucursal = "Allende";
		}

		if ($row_principal[12] == "SINIVA") {
			$iva = "0";
		}elseif ($row_principal[12] == "IVACOM") {
			$iva = "16";
		}

        if ($row_principal[13] == "") {
           	$ieps = "0";
        }elseif($row_principal[13] == "IEPSG"){
        	$ieps = "8";
        }elseif ($row_principal[13] == "IEPS6") {
        	$ieps = "6";
        }

        //Seleccionamos el codigo de la familia padre de la familia del artículo
        $cadena_deptos = "SELECT FAMC_FAMILIAPADRE FROM COM_FAMILIAS WHERE FAMC_DESCRIPCION = '$row_principal[6]'";
		$consulta_deptos = oci_parse($conexion_central, $cadena_deptos);
		oci_execute($consulta_deptos);
		$row_deptos = oci_fetch_row($consulta_deptos);

		//en base a la consulta anterior se realiza otra consulta, con el fin de extraer el nombre de la familia padre
		$d = "SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAMC_FAMILIA = '$row_deptos[0]'";
		$stmt3 = oci_parse($conexion_central, $d);
		oci_execute($stmt3);
		$departamento = oci_fetch_row($stmt3);
	
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		//$objPHPExcel->getActiveSheet()->getStyle('P'.$fila)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $Msucursal)
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $row_principal[2])
	            ->setCellValue('D'.$fila, $row_principal[3])
	            ->setCellValue('E'.$fila, $row_principal[4])
	            ->setCellValue('F'.$fila, $row_principal[5])
                ->setCellValue('G'.$fila, $departamento[0])
                ->setCellValue('H'.$fila, $row_principal[6])
                ->setCellValue('I'.$fila, $row_principal[7])
                ->setCellValue('J'.$fila, $row_principal[8])
                ->setCellValue('K'.$fila, $row_principal[9])
                ->setCellValue('L'.$fila, $row_principal[10])
                ->setCellValue('M'.$fila, $row_principal[11])
                ->setCellValue('N'.$fila, $iva)
                ->setCellValue('O'.$fila, $ieps)
                ->setCellValue('P'.$fila, $row_principal[14])
                ->setCellValue('Q'.$fila, $row_principal[15])
                ->setCellValue('R'.$fila, $row_principal[16])
                ->setCellValue('S'.$fila, $row_principal[17]);



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

        $objPHPExcel->getActiveSheet()
        	->getColumnDimension('S')
        	->setAutoSize(true);

	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="detalle_compras" '.$fecha.' ".xlsx"');
	header('Content-Disposition: attachment;filename="detalle_compras_' . $fecha . '.xlsx"');

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
