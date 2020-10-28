<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

//Fecha y hora actual
$folio_descripcion=$_POST['descripcion'];
$sucursal=$_POST['sucursal'];
$fechahora_folio=$fecha.' '.$hora;

$cadena_folio = "SELECT IFNULL(MAX(FOLIO),0)+1 FROM com_detalleArticulos";
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
        $descripcion = mysqli_real_escape_string($conexion,$row_producto[3]);

        $cadena_insertar = "INSERT INTO com_detalleArticulos (FOLIO, FOLIO_DESCRIPCION, FOLIO_SUCURSAL, ARTC_ARTICULO, ARTC_DESCRIPCION, FOLIO_FECHAHORA, ACTIVO, USUARIO)VALUES('$folio_registro','$folio_descripcion','$sucursal','$row_producto[2]','$descripcion','$fechahora_folio','1','$id_usuario')";
        $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
        //echo $cadena_insertar;
			}
		}
  }
  echo "ok";
 }else{
 	echo "invalido";
 }
}
