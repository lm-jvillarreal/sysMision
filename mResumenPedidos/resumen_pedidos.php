<?php
include '../global_seguridad/verificar_sesion.php';

$sucursal = $_POST['sucursal'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

if(empty($sucursal)){
  $filtro_sucursal="";
}else{
  $filtro_sucursal=" AND SUCURSAL='$sucursal'";
}

/////Total de pedidos en un rango de fechas
$cadena_pedidos="SELECT COUNT(DISTINCT(FOLIO_PEDIDO)) 
                 FROM solicitud_traspasos 
                 WHERE date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')>='$fecha_inicio' 
                 AND date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')<='$fecha_fin' AND ESTATUS='5'".$filtro_sucursal;

$consulta_pedidos=mysqli_query($conexion,$cadena_pedidos);
$row_pedidos=mysqli_fetch_array($consulta_pedidos);
$total_pedidos = number_format($row_pedidos[0], 0, '.', ',');
$prgrs_pedidos=round(100, 2) . '%';
$porc_pedidos="";

//////Total de pedidos con faltante en traspaso
$cadena_noEnviados="SELECT COUNT(DISTINCT(FOLIO_PEDIDO)) 
                    FROM solicitud_traspasos 
                    WHERE date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')>='$fecha_inicio' 
                    AND date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')<='$fecha_fin' AND ESTATUS='5' AND ARTC_ENVIADO='0'".$filtro_sucursal;
$consulta_noEnviados=mysqli_query($conexion,$cadena_noEnviados);
$row_noEnviados=mysqli_fetch_array($consulta_noEnviados);
$total_noEnviados=number_format($row_noEnviados[0], 0, '.', ',');
if($row_noEnviados[0]=='0'){
  $prgrs_noEnviados="0";
}else{
  $prgrs_noEnviados=($row_noEnviados[0]*100)/$row_pedidos[0];
}
$prgrs_noEnviados=round($prgrs_noEnviados, 2) . '%';
$porc_noEnviados=$prgrs_noEnviados." del total de pedidos";

//////Total de pedidos con diferencia vs pedido
$cadena_difPedido="SELECT COUNT(DISTINCT(FOLIO_PEDIDO)) 
                    FROM solicitud_traspasos 
                    WHERE date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')>='$fecha_inicio' 
                    AND date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')<='$fecha_fin' AND ESTATUS='5' AND ARTC_DIFERENCIAPEDIDO='1'".$filtro_sucursal;
$consulta_difPedido=mysqli_query($conexion,$cadena_difPedido);
$row_difPedido=mysqli_fetch_array($consulta_difPedido);
$total_difPedido=number_format($row_difPedido[0], 0, '.', ',');
if($row_difPedido[0]=='0'){
  $prgrs_difPedido="0";
}else{
  $prgrs_difPedido=($row_difPedido[0]*100)/$row_pedidos[0];
}
$prgrs_difPedido=round($prgrs_difPedido, 2) . '%';
$porc_difPedido=$prgrs_difPedido." del total de pedidos";

//////Total de pedidos con diferencia vs traspaso
$cadena_difTraspaso="SELECT COUNT(DISTINCT(FOLIO_PEDIDO)) 
                    FROM solicitud_traspasos 
                    WHERE date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')>='$fecha_inicio' 
                    AND date_format(FECHAHORA_SOLICITA,'%Y-%m-%d')<='$fecha_fin' AND ESTATUS='5' AND ARTC_DIFERENCIATRASPASO='1'".$filtro_sucursal;
$consulta_difTraspaso=mysqli_query($conexion,$cadena_difTraspaso);
$row_difTraspaso=mysqli_fetch_array($consulta_difTraspaso);
$total_difTraspaso=number_format($row_difTraspaso[0], 0, '.', ',');
if($row_difTraspaso[0]=='0'){
  $prgrs_difTraspaso="0";
}else{
  $prgrs_difTraspaso=($row_difTraspaso[0]*100)/$row_pedidos[0];
}
$prgrs_difTraspaso=round($prgrs_difTraspaso, 2) . '%';
$porc_difTraspaso=$prgrs_difTraspaso." del total de pedidos";

$array=array(
  $total_pedidos,
  $prgrs_pedidos,
  $porc_pedidos,
  $total_noEnviados,
  $prgrs_noEnviados,
  $porc_noEnviados,
  $total_difPedido,
  $prgrs_difPedido,
  $porc_difPedido,
  $total_difTraspaso,
  $prgrs_difTraspaso,
  $porc_difTraspaso
);

$array=json_encode($array);
echo $array;
?>