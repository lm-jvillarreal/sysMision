<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2020';

$cadena_NC = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM gastos_aportaciones WHERE anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";
$consulta_NC = mysqli_query($conexion, $cadena_NC);
$row_NC = mysqli_fetch_array($consulta_NC);

$cadena_MANUAL = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM gastos_aportaciones WHERE estatus = '2' AND anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";
$consulta_MANUAL = mysqli_query($conexion, $cadena_MANUAL);
$row_MANUAL = mysqli_fetch_array($consulta_MANUAL);

$cadena_TOTAL = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM gastos_aportaciones where anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";
$consulta_TOTAL = mysqli_query($conexion, $cadena_TOTAL);
$row_TOTAL = mysqli_fetch_array($consulta_TOTAL);

$cadena_gastos = "SELECT SUM(total) FROM gastos_aportaciones where anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";
$consulta_gastos = mysqli_query($conexion, $cadena_gastos);
$row_gastos = mysqli_fetch_array($consulta_gastos);

$cadena_aportaciones = "SELECT SUM(total) FROM aportaciones where anio = '$anio' AND concepto = 'APORTACION ANIVERSARIO'";
$consulta_aportaciones = mysqli_query($conexion, $cadena_aportaciones);
$row_aportaciones = mysqli_fetch_array($consulta_aportaciones);

$gastos = $row_gastos[0];
$aportaciones = $row_aportaciones[0];
$restante = $gastos - $aportaciones;

setlocale(LC_MONETARY, 'en_US');
$restante = money_format('%(#10n', $restante);

$imprimir = '
		<div class="col-md-3">
			<label>Total Registrado:&nbsp;</label>'.$row_NC[0].'
		</div>
		<div class="col-md-3">
			<label>Total Pagado:&nbsp;</label>'.$row_MANUAL[0].'
		</div>
		<div class="col-md-3">
			<label>Total General:&nbsp;</label>'.$row_TOTAL[0].'
		</div>
		<div class="col-md-3">
			<label>Faltante:&nbsp;</label>'.$restante.'
		</div>
';

echo $imprimir;
?>