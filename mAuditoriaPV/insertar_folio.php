<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$proveedor=$_POST['proveedor'];
$folio_descripcion=$_POST['folio_descripcion'];
$sucursal=$_POST['sucursal'];
$usuarios=$_POST['usuarios'];

$cadena_folio = "SELECT IFNULL(MAX(folio),0)+1 FROM auditoria_pv";
$consulta_folio = mysqli_query($conexion,$cadena_folio);
$row_folio = mysqli_fetch_array($consulta_folio);
$folio_registro = $row_folio[0];

$cadena_lista  = "SELECT DISTINCT
                  LIS.ARTC_ARTICULO,
                  artic.ARTC_DESCRIPCION,
                  (SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familia.FAMC_FAMILIAPADRE) AS departamento,
                  familia.FAMC_DESCRIPCION AS familia
                FROM
                  COM_ARTICULOSLISTAPRECIOS lis
                  INNER JOIN PV_ARTICULOS artic ON artic.ARTC_ARTICULO = LIS.ARTC_ARTICULO
                  INNER JOIN COM_FAMILIAS familia ON familia.FAMC_FAMILIA = artic.ARTC_FAMILIA
                WHERE
                  lis.PROC_CVEPROVEEDOR = '$proveedor'";

$consulta_lista = oci_parse($conexion_central, $cadena_lista);
oci_execute($consulta_lista);
echo $cadena_lista;
while($row_lista=oci_fetch_row($consulta_lista)){
  
  $cadena_insertar = "INSERT INTO auditoria_pv (folio, folio_desc, articulo, descripcion, departamento, familia, fecha, hora, activo, usuario, sucursal)VALUES('$folio_registro', '$folio_descripcion', '$row_lista[0]', '$row_lista[1]', '$row_lista[3]', '$row_lista[2]', '$fecha', '$hora', '2', '$id_usuario', '$sucursal')";
  $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
  
  if(empty($usuarios)){
    
  }else{
    $cadena_insertar = "INSERT INTO auditoria_pv (folio, folio_desc, articulo, descripcion, departamento, familia, fecha, hora, activo, usuario, sucursal)VALUES('$folio_registro', '$folio_descripcion', '$row_lista[0]', '$row_lista[1]', '$row_lista[3]', '$row_lista[2]', '$fecha', '$hora', '2', '$usuarios', '$sucursal')";
    $consulta_insertar=mysqli_query($conexion, $cadena_insertar);
  }
}

?>