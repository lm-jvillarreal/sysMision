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

$cadenaTotal = "SELECT COUNT(id) FROM registro_boletos WHERE fecha between '$fecha_inicio' AND '$fecha_fin'";
$consultaTotal = mysqli_query($conexion, $cadenaTotal);
$rowTotal = mysqli_fetch_array($consultaTotal);

$cadenaDo = "SELECT COUNT(id) FROM registro_boletos WHERE sucursal = '1' AND fecha between '$fecha_inicio' AND '$fecha_fin'";
$consultaDo = mysqli_query($conexion, $cadenaDo);
$rowDO = mysqli_fetch_array($consultaDo);

$porcientoDo=($rowDO[0]/$rowTotal[0])*100;
$porcientoDo = round($porcientoDo,2);

$cadenaArb = "SELECT COUNT(id) FROM registro_boletos WHERE sucursal = '2' AND fecha between '$fecha_inicio' AND '$fecha_fin'";
$consultaArb = mysqli_query($conexion, $cadenaArb);
$rowArb = mysqli_fetch_array($consultaArb);

$porcientoArb=($rowArb[0]/$rowTotal[0])*100;
$porcientoArb = round($porcientoArb,2);

$cadenaVill = "SELECT COUNT(id) FROM registro_boletos WHERE sucursal = '3' AND fecha between '$fecha_inicio' AND '$fecha_fin'";
$consultaVill = mysqli_query($conexion, $cadenaVill);
$rowVill = mysqli_fetch_array($consultaVill);

$porcientoVill=($rowVill[0]/$rowTotal[0])*100;
$porcientoVill = round($porcientoVill,2);

$cadenaAll = "SELECT COUNT(id) FROM registro_boletos WHERE sucursal = '4' AND fecha between '$fecha_inicio' AND '$fecha_fin'";
$consultaAll = mysqli_query($conexion, $cadenaAll);
$rowAll = mysqli_fetch_array($consultaAll);

$porcientoAll=($rowAll[0]/$rowTotal[0])*100;
$porcientoAll = round($porcientoAll,2);

$array = array(
  $rowDO[0],
  $porcientoDo,
  $rowArb[0],
  $porcientoArb,
  $rowVill[0],
  $porcientoVill,
  $rowAll[0],
  $porcientoAll
);

$array_datos = json_encode($array);
echo $array_datos;
?>