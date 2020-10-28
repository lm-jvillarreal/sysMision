<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = $_POST['anio'];
$anio_pasado = $anio-1;
$concepto = $_POST['concepto'];
$id_comprador = $_POST['id_comprador'];

//aramirez = 8
//frodriguez = 34
//cweinmann = 11
//gcharur = 7
//jreyna = 9

$cadena_total = "SELECT FORMAT(SUM(total),2)  FROM aportaciones WHERE anio = '$anio_pasado' AND concepto = '$concepto'";
$consulta_total = mysqli_query($conexion, $cadena_total);
$row_total = mysqli_fetch_array($consulta_total);

$cadena_proyecta = "SELECT IFNULL(FORMAT(SUM(total),2),0)  FROM aportaciones WHERE anio = '$anio_pasado' AND concepto = '$concepto' AND id_comprador = '$id_comprador'";
$consulta_proyecta = mysqli_query($conexion, $cadena_proyecta);
$row_proyecta = mysqli_fetch_array($consulta_proyecta);

$cadena_aportaciones = "SELECT IFNULL(FORMAT(SUM(total),2),0)  FROM aportaciones WHERE anio = '$anio' AND concepto = '$concepto' AND id_comprador = '$id_comprador'";
$consulta_aportaciones = mysqli_query($conexion, $cadena_aportaciones);
$row_aportaciones = mysqli_fetch_array($consulta_aportaciones);

if($row_aportaciones[0]==0||$row_proyecta[0]==0){
	$porcentaje_aportaciones =0;
}else{
	$porcentaje_aportaciones = ($row_aportaciones[0]/$row_proyecta[0])*100;
}
if($row_proyecta[0]==0||$row_total[0]==0){
	$porcentaje_pasado=0;
}else{
	$porcentaje_pasado = ($row_proyecta[0]/$row_total[0])*100;
}

$proyeccion = "$".$row_proyecta[0];
$aportaciones = "$".$row_aportaciones[0];
$porcientoProy = ROUND($porcentaje_pasado,2);
$porcientoProy = $porcientoProy."%";
$porcientoAp = ROUND($porcentaje_aportaciones,2);
$porcientoAp = $porcientoAp."%";

if($row_aportaciones[0]>=$row_proyecta[0]){
	$estilo = "info-box bg-green";
}else{
	$estilo = "info-box bg-red";
}

$array = array(
	$proyeccion,
	$porcientoProy,
	$aportaciones,
	$porcientoAp,
	$estilo
);
$array_datos = json_encode($array);
echo $array_datos;
?>