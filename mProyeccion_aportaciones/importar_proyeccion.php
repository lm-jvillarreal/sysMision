<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');

include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$id_comprador = $_POST['id_comprador'];

$cadena_concepto = "SELECT id, nombre, ano FROM ap_conceptos WHERE activo = '1'";
$consulta_concepto = mysqli_query($conexion, $cadena_concepto);
$row_concepto = mysqli_fetch_array($consulta_concepto);

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
		  
			$codigo_proveedor= "";
			if(isset($Row[0])) {
				$codigo_proveedor= mysqli_real_escape_string($conexion,$Row[0]);
			}
			$monto= "";
			if(isset($Row[1])) {
				$monto= mysqli_real_escape_string($conexion,$Row[1]);
			}
		

			// Guardamos en base de datos
			if (!empty($codigo_proveedor)) {

				$cadena_consulta = "SELECT PR.PROC_CVEPROVEEDOR, PR.PROC_NOMBRE FROM CXP_PROVEEDORES pr WHERE PR.PROC_CVEPROVEEDOR = '$codigo_proveedor'";
				$st = oci_parse($conexion_central, $cadena_consulta);
				oci_execute($st);
				$row_proveedor = oci_fetch_row($st);
				
				$cadena_insertar = "INSERT INTO ap_proyeccion (cve_proveedor, nombre_proveedor, monto, id_concepto, ano, nombre_concepto, id_comprador, fecha, hora, activo, usuario)VALUES('$row_proveedor[0]','$row_proveedor[1]', '$monto', '$row_concepto[0]', '$row_concepto[2]', '$row_concepto[1]', '$id_comprador', '$fecha', '$hora', '1', '$id_usuario')";
				$insertar_proyeccion = mysqli_query($conexion, $cadena_insertar);

				if (empty($insertar_proyeccion)) {
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