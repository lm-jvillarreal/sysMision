<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio = $_POST['folio'];

$cadenaConsulta = "SELECT artc_articulo, id from monitoreo_teoricos WHERE folio = '$folio'";
$consultaCodigo = mysqli_query($conexion, $cadenaConsulta);
while($rowCodigo = mysqli_fetch_array($consultaCodigo)){
  $cadenaDescripcion = "SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$rowCodigo[0]'";
  $st = oci_parse($conexion_central, $cadenaDescripcion);
  oci_execute($st);
  $rowDescripcion = oci_fetch_row($st);

  $cadenaActualiza = "UPDATE monitoreo_teoricos SET artc_descripcion = '$rowDescripcion[0]' WHERE id = '$rowCodigo[1]'";
  $actualizaDescripcion = mysqli_query($conexion, $cadenaActualiza);
}
echo "ok";
?>