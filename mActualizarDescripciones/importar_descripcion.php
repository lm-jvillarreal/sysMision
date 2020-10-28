<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN','AL32UTF8');

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

if( isset($_POST["action"]) ){
 
 $error = false;
 
 $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
 
 if(in_array($_FILES["file"]["type"],$allowedFileType)){

	$ruta = "formatos/" . $_FILES['file']['name'];
	move_uploaded_file($_FILES['file']['tmp_name'], $ruta);

	$Reader = new SpreadsheetReader($ruta);

	$sheetCount = count($Reader->sheets());

	for($i=0;$i<$sheetCount;$i++){

		$Reader->ChangeSheet($i);
			
		$primera = true;
		foreach ($Reader as $Row)
		{
	                
	                // Evitamos la primer linea
			if($primera){
				$primera = false;
				continue;
			}
			// Guardamos en base de datos
			if (!empty($Row[0])) {
				//$conv = mysqli_real_escape_string($conexion, $Row[1]);
				//$field = iconv("UTF-8", "ISO-8859-1", strval($conv));

				$stid = oci_parse($conn, "UPDATE COM_ARTICULOS SET ARTC_DESCRIPCION = '$Row[1]' WHERE artc_articulo = '$Row[0]'");
				oci_execute($stid);
				oci_free_statement($stid);

				$stid = oci_parse($conn, "UPDATE COM_ARTICULOS SET ARTC_DESCRIPCION_LARGA = '$Row[1]' WHERE artc_articulo = '$Row[0]'");
				oci_execute($stid);
			}
		}
	}	
	oci_free_statement($stid);
	oci_close($conn);
	echo "ok";
 }else{
 	echo "invalido";
 }
}
