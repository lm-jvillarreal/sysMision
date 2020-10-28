<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

//include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$fecha_dos = date("d/M/y");
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

				$stid = oci_parse($conn, "UPDATE COM_ARTICULOS SET ARTN_ESTATUS = 2, ARTD_BAJA = '$fecha_dos', ARTC_DESCRIPCION = '$Row[1]',ARTC_DESCRIPCION_LARGA = '$Row[1]' WHERE ARTC_ARTICULO = '$Row[0]'");
				oci_execute($stid);
				//oci_free_statement($stid);
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