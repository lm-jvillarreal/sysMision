<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$id_comprador = $_POST['id_comprador'];

$cadenaTotal = "SELECT ifnull(SUM(total),0) FROM fondos";
$consultaTotal = mysqli_query($conexion,$cadenaTotal);
$rowTotal = mysqli_fetch_array($consultaTotal);
$totalGeneral = $rowTotal[0];

$cadenaAbonos = "SELECT ifnull(SUM(total),0) FROM fondos where id_comprador = '$id_comprador'";
$consultaAbonos = mysqli_query($conexion, $cadenaAbonos);
$rowAbonos = mysqli_fetch_array($consultaAbonos);
$totalAbonos = $rowAbonos[0];

$cadenaCargos = "SELECT id, folio_oferta, articulo, descripcion, fecha_inicio, fecha_fin, tipo, cantidad, sucursal FROM cargos_fondos where id_comprador = '$id_comprador'";
$consultaCargos = mysqli_query($conexion, $cadenaCargos);
$totalCargos = 0;
$totalCodigo=0;
while($rowCargos = mysqli_fetch_array($consultaCargos)){
  $fechaInicio = str_replace("-", "", $rowCargos[4]);
  $fechaFin = str_replace("-", "", $rowCargos[5]);

  $cadenaTicket = "SELECT SUM(ARTN_CANTIDAD)
                  FROM PV_ARTICULOSTICKET 
                  WHERE ticn_aaaammddventa >= '$fechaInicio' AND ticn_aaaammddventa <= '$fechaFin'
                  AND ARTC_ARTICULO = '$rowCargos[2]'
                  GROUP BY ARTC_ARTICULO";
                    
  $st = oci_parse($conexion_central, $cadenaTicket);
  oci_execute($st);
  
  $rowTicket = oci_fetch_row($st);
  $cantidadArticulo = $rowTicket[0];
  //$precioArticulo = $rowTicket[1];

  if($rowCargos[6]=="CANTIDAD"){
    $totalCodigo = $cantidadArticulo*$rowCargos[7];

  }elseif($rowCargos[6]=="PORCENTAJE"){
    $porcentaje = $rowCargos[7]/100;
    $totalCodigo = $precioArticulo*$porcentaje;
    $totalCodigo = $totalCodigo * $cantidadArticulo;
  }
  $totalCargos=$totalCargos+$totalCodigo;
}
$resto = $totalAbonos-$totalCargos;
if($totalGeneral<=0||$resto<=0){
  $porc = '0';
}else{
  $porc= ($resto/$totalGeneral)*100;
  $porc = round($porc,2);
}

$array = array(
  $resto,
  $porc
);
$array_datos = json_encode($array);
echo $array_datos;
?>