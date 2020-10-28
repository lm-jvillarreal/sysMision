<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$tiempo = $_POST['rango'];
$folio = $_POST['fecha'];
$folio = str_replace('-','',$folio);
$estado = $_POST['estado'];

$cuerpo="";

if($estado=='0'){
	$renglon = "";
	$cuerpo = $cuerpo.$renglon;
}else{
$horaIn = date('Y-m-d 08:00:00');
$horaInicio = new DateTime($horaIn);

$horaFin = date('Y-m-d 22:00:00');
$horaFinal = new DateTime($horaFin);

$intervalo = $horaInicio->diff($horaFinal);
$intervalo= $intervalo->format('%H');

$minTotales = $intervalo * 60;
$iteraciones = $minTotales/$tiempo;
$iteraciones = ceil($iteraciones);

$rangoIni = new DateTime($horaIn);
$horaResult=new DateTime($horaIn);
for($i=1;$i<=$iteraciones;$i++){
	$rangoIni=$horaResult;
	$rangoStr = $rangoIni->format('H:i');
	$horaResult->add(new DateInterval('PT'.$tiempo.'M'));
	$horaStr =$horaResult->format('H:i');

	$cadenaVentas="SELECT (SELECT COUNT(*)
									FROM pv_tickets 
									WHERE ticc_sucursal='1' 
									AND ticn_aaaammddventa='$folio' 
									AND TO_CHAR(ticd_fechahoraventa,'HH24:mi') > '$rangoStr'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:MI')<='$horaStr'
									) DO,
									(SELECT COUNT(*)
									FROM pv_tickets 
									WHERE ticc_sucursal='2' 
									AND ticn_aaaammddventa='$folio'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:mi') > '$rangoStr'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:MI')<='$horaStr'
									) ARB,
									(SELECT COUNT(*)
									FROM pv_tickets 
									WHERE ticc_sucursal='3' 
									AND ticn_aaaammddventa='$folio'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:mi') > '$rangoStr'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:MI')<='$horaStr'
									) VILL,
									(SELECT COUNT(*)
									FROM pv_tickets 
									WHERE ticc_sucursal='4' 
									AND ticn_aaaammddventa='$folio'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:mi') > '$rangoStr'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:MI')<='$horaStr'
									) ALLE,
									(SELECT COUNT(*)
									FROM pv_tickets 
									WHERE ticc_sucursal='5' 
									AND ticn_aaaammddventa='$folio'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:mi') > '$rangoStr'
									AND TO_CHAR(ticd_fechahoraventa,'HH24:MI')<='$horaStr'
									) LP
									FROM DUAL
									";
	$consultaVentas = oci_parse($conexion_central,$cadenaVentas);
	oci_execute($consultaVentas);
	$row_ventas = oci_fetch_row($consultaVentas);
  $renglon = "
		{
			\"hora\":\"$rangoStr - $horaStr\",
			\"DO\":\"$row_ventas[0]\",
			\"ARB\":\"$row_ventas[1]\",
			\"VILL\":\"$row_ventas[2]\",
			\"ALL\":\"$row_ventas[3]\",
			\"LP\":\"$row_ventas[4]\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>