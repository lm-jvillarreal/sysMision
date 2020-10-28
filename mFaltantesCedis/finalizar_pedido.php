<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio = $_POST['folio'];

$cadena_consulta = "SELECT  ID, ARTC_ARTICULO, ARTC_DESCRIPCION, CANTIDAD_SOLICITA, CANTIDAD_SURTIDA, FOLIO_TRASPASO FROM solicitud_traspasos WHERE FOLIO_PEDIDO='$folio'";
$consulta_detalle = mysqli_query($conexion,$cadena_consulta);
while($rowDetalle=mysqli_fetch_array($consulta_detalle)){

  $cadenaTraspaso = "SELECT rtrn_cantidad_salida, rtrn_cantidad_entrada FROM INV_RENGLONES_TRANSFERENCIA WHERE tran_id_consecutivo='$rowDetalle[5]' AND ARTC_ARTICULO='$rowDetalle[1]'";
  $consultaTraspaso = oci_parse($conexion_central,$cadenaTraspaso);
  oci_execute($consultaTraspaso);
  $rowTraspaso = oci_fetch_row($consultaTraspaso);
  $conteo=count($rowTraspaso[0]);
  if($conteo==0){
    $artc_enviado='0';
    $artc_diferenciapedido='1';
    $artc_diferenciatraspaso='0';
    $artc_cantidadrecibida='0';
  }else{
    $artc_enviado='1';
    if($rowDetalle[3]==$rowDetalle[4]){
      $artc_diferenciapedido="0";
    }else{
      $artc_diferenciapedido='1';
    }
    if($rowTraspaso[0]==$rowTraspaso[1]){
      $artc_diferenciatraspaso='0';
    }else{
      $artc_diferenciatraspaso='1';
    }
    $artc_cantidadrecibida=$rowTraspaso[1];
  }

  $cadenaFinaliza="UPDATE solicitud_traspasos SET ARTC_ENVIADO='$artc_enviado', ARTC_DIFERENCIAPEDIDO='$artc_diferenciapedido', ARTC_DIFERENCIATRASPASO='$artc_diferenciatraspaso', CANTIDAD_RECIBIDA='$artc_cantidadrecibida', ESTATUS='5' WHERE FOLIO_PEDIDO='$folio' AND ARTC_ARTICULO='$rowDetalle[1]'";
  $finalizaPedido=mysqli_query($conexion,$cadenaFinaliza);
  echo "ok";
}
?>