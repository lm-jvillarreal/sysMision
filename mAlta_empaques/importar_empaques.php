<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

//include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$fecha_dos = date("d/m/Y");
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

				$stid = oci_parse($conn, "INSERT INTO INV_ARTICULOS_EMPAQUE (CTBS_CIA, ARTC_ARTICULO, AREC_EMPAQUE, AREC_DESCRIPCION, AREN_CANTIDAD)VALUES('1','$Row[0]','$Row[1]','$Row[2]','$Row[3]')");
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

?>