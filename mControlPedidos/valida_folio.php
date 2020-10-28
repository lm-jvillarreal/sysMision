<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$pedido = $_POST['pedido'];
$traspaso = $_POST['traspaso'];

$cadenaValidar = "SELECT * FROM INV_TRANSFERENCIAS WHERE TRAN_ID_CONSECUTIVO='$traspaso' AND TRAN_ESTATUS='1'";
$stValidar = oci_parse($conexion_central,$cadenaValidar);
oci_execute($stValidar);
$rowValidar = oci_fetch_row($stValidar);
$conteo=count($rowValidar[0]);

if($conteo==0){
  echo "no_existe";
}else{
  $cadenaEstatus = "UPDATE solicitud_traspasos SET ESTATUS='4', FOLIO_TRASPASO='$traspaso' WHERE FOLIO_PEDIDO='$pedido'";
  $consultaEstatus=mysqli_query($conexion,$cadenaEstatus);
  echo "validado";
}
?>