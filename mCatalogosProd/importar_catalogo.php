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

 	$cadena_noCat = "SELECT MAX(no_catalogo) FROM cp_catalogos";
	$consulta_noCat = mysqli_query($conexion, $cadena_noCat);
	$row_noCat = mysqli_fetch_array($consulta_noCat);
	$noCat = $row_noCat[0] + 1;

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
		

			// Guardamos en base de datos
			if (!empty($codigo_producto)) {

				$nombre_catalogo = $_POST['nombre_catalogo'];

				$cadena_consulta = "SELECT ARTC_DESCRIPCION, ARTC_FAMILIA FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
				$st = oci_parse($conexion_central, $cadena_consulta);
				oci_execute($st);
				$row_producto = oci_fetch_row($st);
				
				$cadena_insertar = "INSERT INTO cp_catalogos (no_catalogo, nombre_catalogo, cve_producto, desc_producto, familia_producto, sucursal, fecha, hora, activo, usuario)VALUES('$noCat','$nombre_catalogo', '$codigo_producto', '$row_producto[0]', '$row_producto[1]', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
				$insertar_catalogo = mysqli_query($conexion, $cadena_insertar);

				if (empty($insertar_catalogo)) {
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