<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha=date("Y-m-d");
$hora=date("H:i:s");

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

if($fecha_inicio==""){
  $fecha_inicio = $fecha;
}
if($fecha_fin==""){
  $fecha_fin = $fecha;
}

$cadenaTotal = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin')";
$consultaTotal = mysqli_query($conexion,$cadenaTotal);
$rowTotal = mysqli_fetch_array($consultaTotal);

$cadenaDO = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND id_sucursal = '1'";
$consultaDO = mysqli_query($conexion,$cadenaDO);
$rowDO = mysqli_fetch_array($consultaDO);

$porcientoDo=($rowDO[0]/$rowTotal[0])*100;
$porcientoDo = round($porcientoDo,2);

$cadenaArb = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND id_sucursal = '2'";
$consultaArb = mysqli_query($conexion, $cadenaArb);
$rowArb = mysqli_fetch_array($consultaArb);

$porcientoArb=($rowArb[0]/$rowTotal[0])*100;
$porcientoArb = round($porcientoArb,2);

$cadenaVill = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND id_sucursal = '3'";
$consultaVill = mysqli_query($conexion, $cadenaVill);
$rowVill = mysqli_fetch_array($consultaVill);

$porcientoVill=($rowVill[0]/$rowTotal[0])*100;
$porcientoVill = round($porcientoVill,2);

$cadenaAll = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND id_sucursal = '4'";
$consultaAll = mysqli_query($conexion, $cadenaAll);
$rowAll = mysqli_fetch_array($consultaAll);

$porcientoAll=($rowAll[0]/$rowTotal[0])*100;
$porcientoAll = round($porcientoAll,2);

$cadenaLP = "SELECT COUNT(id) FROM registroIncidencias_vidvig WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND id_sucursal = '5'";
$consultaLP = mysqli_query($conexion, $cadenaLP);
$rowLP = mysqli_fetch_array($consultaLP);

$porcientoLP=($rowLP[0]/$rowTotal[0])*100;
$porcientoLP = round($porcientoLP,2);

$array = array(
  $rowDO[0],
  $porcientoDo,
  $rowArb[0],
  $porcientoArb,
  $rowVill[0],
  $porcientoVill,
  $rowAll[0],
  $porcientoAll,
  $rowLP[0],
  $porcientoLP
);

$array_datos = json_encode($array);
echo $array_datos;
?>