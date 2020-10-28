<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$cadenaCodigos="SELECT DISTINCT(cve_articulo) FROM faltantes_pasven";
$consultaArticulos=mysqli_query($conexion,$cadenaCodigos);
while($rowCodigos=mysqli_fetch_array($consultaArticulos)){
  $cadenaDesc="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$rowCodigos[0]'";
  $st = oci_parse($conexion_central, $cadenaDesc);
  oci_execute($st);
  while($rowDescripcion=oci_fetch_row($st)){
    $escape_desc=mysqli_real_escape_string($conexion,$rowDescripcion[0]);
    $cadenaActualizar="UPDATE faltantes_pasven SET descripcion_articulo='$escape_desc' WHERE cve_articulo='$rowCodigos[0]'";
    $actualizarDesc=mysqli_query($conexion,$cadenaActualizar);
  }
}
?>