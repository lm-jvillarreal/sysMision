<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$cadenaTotal = "SELECT NVL(COUNT(*),0) FROM INV_TRANSFERENCIAS WHERE TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '$fecha_fin', 'YYYY/MM/DD' ))+1";
$consultaTotal = oci_parse($conexion_central, $cadenaTotal);
oci_execute($consultaTotal);
$rowTotal = oci_fetch_row($consultaTotal);
$totalGeneral = $rowTotal[0];
if($totalGeneral==0){
  $totalDO=0;
  $porcentajeDO=0;
  $totalARB=0;
  $porcentajeARB=0;
  $totalVILL=0;
  $porcentajeVILL=0;
  $totalALL=0;
  $porcentajeALL=0;
}else{
  $cadenaSucursales = "SELECT
  (SELECT NVL(COUNT(*),0) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '1' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '$fecha_fin', 'YYYY/MM/DD' ))+1) DO,
  (SELECT NVL(COUNT(*),0) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '2' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '$fecha_fin', 'YYYY/MM/DD' ))+1) ARB,
  (SELECT NVL(COUNT(*),0) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '3' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '$fecha_fin', 'YYYY/MM/DD' ))+1) VILL,
  (SELECT NVL(COUNT(*),0) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '4' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '$fecha_fin', 'YYYY/MM/DD' ))+1) AL
  FROM DUAL";
  $consultaSucursales = oci_parse($conexion_central, $cadenaSucursales);
  oci_execute($consultaSucursales);
  $rowSucursales = oci_fetch_row($consultaSucursales);
  $totalDO = $rowSucursales[0];
  $porcentajeDO = ($totalDO/$totalGeneral)*100;
  $totalARB = $rowSucursales[1];
  $porcentajeARB = ($totalARB/$totalGeneral)*100;
  $totalVILL = $rowSucursales[2];
  $porcentajeVILL = ($totalVILL/$totalGeneral)*100;
  $totalALL = $rowSucursales[3];
  $porcentajeALL = ($totalALL/$totalGeneral)*100;
}

$array =array(
  $totalDO,
  round($porcentajeDO,2),
  $totalARB,
  round($porcentajeARB,2),
  $totalVILL,
  round($porcentajeVILL,2),
  $totalALL,
  round($porcentajeALL,2)
);
$array_datos = json_encode($array);
echo $array_datos;
?>