<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

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
				$cadena_insertar = "INSERT INTO iva_acreditable (tipo_poliza, tipo_pago, RFC, nombre_proveedor, no_factura, monto_iva, fecha, hora, activo, usuario)VALUES('$Row[0]','$Row[1]','$Row[2]','$Row[3]','$Row[4]','$Row[5]','$fecha','$hora','1','$id_usuario')";
				$insertar_registro = mysqli_query($conexion,$cadena_insertar);
			}
		}
	}	
	echo "ok";
 }else{
 	echo "invalido";
 }
}
