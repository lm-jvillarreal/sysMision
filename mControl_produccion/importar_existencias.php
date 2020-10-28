<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

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

			// Obtenemos informacion
		  
			$codigo_producto= "";
			if(isset($Row[0])) {
				$codigo_producto= mysqli_real_escape_string($conexion,$Row[0]);
			}
			$existencia_producto= "";
			if(isset($Row[1])) {
				$existencia_producto= mysqli_real_escape_string($conexion,$Row[1]);
			}
		

			// Guardamos en base de datos
			if (!empty($codigo_producto)) {

				$cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
				$st = oci_parse($conexion_central, $cadena_consulta);
				oci_execute($st);
				$row_producto = oci_fetch_row($st);
				
				$cadena_insertar = "INSERT INTO cp_historial_movimientos (cve_producto, desc_producto, inv_arranque, baja_merma, baja_venta, inv_cierre, sucursal, fecha, hora, activo, usuario)VALUES('$codigo_producto', '$row_producto[0]', '$existencia_producto', '0', '0', '0', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
				$insertar_existencia = mysqli_query($conexion, $cadena_insertar);

				if (empty($insertar_existencia)) {
					$error = true;
				}
			}
		}
	}
	echo "ok";
 }else{
 	echo "invalido";
 }
}

?>