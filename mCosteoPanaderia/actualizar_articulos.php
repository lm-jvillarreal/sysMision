<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$cadenaListar="SELECT ARTC_ARTICULO FROM pasteleria_articulos WHERE ARTC_DESCRIPCION=''";
$consultaVacios=mysqli_query($conexion,$cadenaListar);
while($row=mysqli_fetch_array($consultaVacios)){
  $cadenaArtc="SELECT ARTC_DESCRIPCION, ARTC_UNIMEDIDA_VENTA FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$row[0]'";
  echo $cadenaArtc;
  $st = oci_parse($conexion_central, $cadenaArtc);
  oci_execute($st);
  $rowDescripcion = oci_fetch_array($st);
  $cadenaUpdate="UPDATE pasteleria_articulos SET ARTC_DESCRIPCION='$rowDescripcion[0]', UNIMEDIDA_COMPRA='$rowDescripcion[1]' WHERE ARTC_ARTICULO='$row[0]'";
  $update=mysqli_query($conexion,$cadenaUpdate);
}
?>