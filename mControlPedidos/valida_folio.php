<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$pedido = $_POST['pedido'];
$traspaso = $_POST['traspaso'];

$cadenaValidar = "SELECT * FROM INV_TRANSFERENCIAS WHERE TRAN_ID_CONSECUTIVO='$traspaso' AND TRAN_ESTATUS='1'";
$stValidar = oci_parse($conexion_central,$cadenaValidar);
oci_execute($stValidar);
$rowValidar = oci_fetch_row($stValidar);
$conteo=(count($rowValidar[0]));

if($conteo==0){
  echo "no_existe";
}else{
  //Validar contenido 
  $cadenaContenido = "SELECT ARTC_ARTICULO FROM INV_RENGLONES_TRANSFERENCIA WHERE TRAN_ID_CONSECUTIVO='$traspaso'";
  $stContenido =  oci_parse($conexion_central, $cadenaContenido);
  oci_execute($stContenido);
  $rowValidar=oci_fetch_row($stContenido);
  $conteo=count($rowValidar[0]);
  if($conteo>1){
    echo "no_valido";
  }elseif($conteo==1){
    if($rowValidar[0]=='10'){
      $cadenaEstatus = "UPDATE solicitud_traspasos SET ESTATUS='4', FOLIO_TRASPASO='$traspaso' WHERE FOLIO_PEDIDO='$pedido'";
      $consultaEstatus=mysqli_query($conexion,$cadenaEstatus);
      echo "validado";
    }else{
      echo 'no_valido';
    }
  }
}
?>