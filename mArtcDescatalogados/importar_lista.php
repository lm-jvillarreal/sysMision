<?php
require_once('../plugins/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('../plugins/spreadsheet-reader/SpreadsheetReader.php');
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

$conn = oci_connect('INFOFIN', 'INFOFIN', '200.1.1.185/INFOFIN');

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fechahora=date("Y-m-d H:i:s");

$sucursal = $_POST['sucursal'];

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
        $cadenaValidar="SELECT COUNT(ID) FROM ARTC_DESCATALOGADOS WHERE ARTC_ARTICULO='$Row[0]' AND ID_SUCURSAL='$sucursal'";
        $validar=mysqli_query($conexion,$cadenaValidar);
        $rowValidar=mysqli_fetch_array($validar);
        if($rowValidar[0]=='0'){
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

          $cadena_insertar = "INSERT INTO ARTC_DESCATALOGADOS(ARTC_ARTICULO, ARTC_DESCRIPCION, ID_SUCURSAL, FECHAHORA, ACTIVO, USUARIO)VALUES('$Row[0]','$descripcion','$sucursal','$fechahora','1','$id_usuario')";
          $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
          //echo $cadena_insertar;
        }
			}
		}
  }
  echo "ok";
 }else{
 	echo "invalido";
 }
}
