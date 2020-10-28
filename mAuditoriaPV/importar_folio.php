<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");
$folio_descripcion = $_POST['folio_descripcion'];
$sucursal = $_POST['sucursal'];
$usuarios = $_POST['usuarios'];

$cadena_folio = "SELECT IFNULL(MAX(folio),0)+1 FROM auditoria_pv";
$consulta_folio = mysqli_query($conexion,$cadena_folio);
$row_folio = mysqli_fetch_array($consulta_folio);
$folio_registro = $row_folio[0];

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
        $cadena_consulta = "SELECT 
                            (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
                            FAM.FAMC_DESCRIPCION,
                            COM_ARTICULOS.ARTC_ARTICULO, 
                            COM_ARTICULOS.ARTC_DESCRIPCION
                            FROM COM_ARTICULOS
                            INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
                            WHERE com_articulos.artc_articulo = '$Row[0]'";

        $st = oci_parse($conn, $cadena_consulta);
        oci_execute($st);

        $row_producto = oci_fetch_row($st);
        $departamento = $row_producto[0];
        $familia = $row_producto[1];
        $descripcion = $row_producto[3];

        $cadena_insertar = "INSERT INTO auditoria_pv (folio, folio_desc, articulo, descripcion, departamento, familia, fecha, hora, activo, usuario, sucursal)VALUES('$folio_registro', '$folio_descripcion', '$Row[0]', '$descripcion', '$familia', '$departamento', '$fecha', '$hora', '2', '$id_usuario', '$sucursal')";
        $consulta_insertar=mysqli_query($conexion, $cadena_insertar);

        if(empty($usuarios)){

        }else{
          $cadena_insertar = "INSERT INTO auditoria_pv (folio, folio_desc, articulo, descripcion, departamento, familia, fecha, hora, activo, usuario, sucursal)VALUES('$folio_registro', '$folio_descripcion', '$Row[0]', '$descripcion', '$familia', '$departamento', '$fecha', '$hora', '2', '$usuarios', '$sucursal')";
          $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
        }
        //echo $cadena_insertar;
			}
		}
  }
  echo "ok";
 }else{
 	echo "invalido";
 }
}
