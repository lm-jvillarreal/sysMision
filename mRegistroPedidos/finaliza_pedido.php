<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';
$fechahora=$fecha.' '.$hora;
$folio_ticket=$_POST['folio_ticket'];
$prefijo=$_POST['prefijo'];
$consecutivo=$_POST['consecutivo'];
$id_pedido=$_POST['id_pedido'];
$total_ticket=$_POST['total_ticket'];
$metodo_pago =$_POST['metodo_pago'];
if($folio_ticket==""){
  echo "vacio";
}else{
  if($id_sede=='1'){
    $conexion_central = $conexion_do;
  }elseif($id_sede=='2'){
    $conexion_central = $conexion_arb;
  }elseif($id_sede=='3'){
    $conexion_central = $conexion_vill;
  }elseif($id_sede=='4'){
    $conexion_central = $conexion_all;
  }
  
  $cadenaValidar ="SELECT * FROM PVS_TICKETS WHERE TICN_AAAAMMDDVENTA = $prefijo AND TICN_FOLIO = $consecutivo";
  $consulta_ticket = oci_parse($conexion_central, $cadenaValidar);
  oci_execute($consulta_ticket);
  $row = oci_fetch_row($consulta_ticket);
  $conteo=count($row[0]);
  if($conteo==0){
    echo "no_existe";
  }else{
    $cadenaFinaliza="UPDATE pv_pedidos SET PEDIDO_FOLIOTICKET='$folio_ticket', TIPO_PEDIDO='$metodo_pago', FECHA_SURTEPEDIDO='$fecha', HORA_FINALSURTIDO='$fechahora', ESTATUS_SURTIDO='4', ESTATUS_PEDIDO='2', PEDIDO_TOTALTICKET='$total_ticket' WHERE ID='$id_pedido'";
    $finalizaPedido=mysqli_query($conexion,$cadenaFinaliza);
    echo "ok";
  }
}
?>