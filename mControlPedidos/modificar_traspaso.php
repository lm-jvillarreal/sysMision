<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$pedido = $_POST['pedido'];
$traspaso = $_POST['traspaso'];

$cadenaLimpiar = "DELETE FROM INV_RENGLONES_TRANSFERENCIA WHERE TRAN_ID_CONSECUTIVO='$traspaso'";
$stLimpiar = oci_parse($conexion_central, $cadenaLimpiar);
oci_execute($stLimpiar);
oci_free_statement($stLimpiar);

$cadenaArticulos = "SELECT ARTC_ARTICULO, CANTIDAD_SURTIDA FROM solicitud_traspasos WHERE FOLIO_PEDIDO ='$pedido'";
$consultaArticulos = mysqli_query($conexion,$cadenaArticulos);

while($rowArticulos = mysqli_fetch_array($consultaArticulos)){
  $cadenaInsertar = "INSERT INTO INV_RENGLONES_TRANSFERENCIA (CTBS_CIA, TRAN_ID_CONSECUTIVO, ARTC_ARTICULO, RTRN_CANTIDAD_SALIDA)VALUES('1','$traspaso','$rowArticulos[0]','$rowArticulos[1]')";
  $stInsertar=oci_parse($conexion_central,$cadenaInsertar);
  oci_execute($stInsertar);
  oci_free_statement($stInsertar);
}
$cadenaEstatus = "UPDATE solicitud_traspasos SET ESTATUS='3', FOLIO_TRASPASO='$traspaso' WHERE FOLIO_PEDIDO='$pedido'";
$consultaEstatus=mysqli_query($conexion,$cadenaEstatus);
echo $cadenaInsertar;
?>