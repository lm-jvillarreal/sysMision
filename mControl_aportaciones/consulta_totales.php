<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2020';

$filtro_rp = (!empty($registros_propios) == '1') ? "WHERE id_comprador = '$id_usuario' AND concepto = 'APORTACION ANIVERSARIO'" : "WHERE activo = '1' AND concepto = 'APORTACION ANIVERSARIO'";

$cadena_escarg = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM aportaciones ".$filtro_rp." AND tipo_movimiento = 'ESCARG' AND anio = '$anio'";
$consulta_escarg = mysqli_query($conexion, $cadena_escarg);
$row_escarg = mysqli_fetch_array($consulta_escarg);

$cadena_NC = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM aportaciones ".$filtro_rp." AND tipo_movimiento = 'NC' AND anio = '$anio'";
$consulta_NC = mysqli_query($conexion, $cadena_NC);
$row_NC = mysqli_fetch_array($consulta_NC);

$cadena_MANUAL = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM aportaciones ".$filtro_rp." AND tipo_movimiento = 'MANUAL' AND anio = '$anio'";
$consulta_MANUAL = mysqli_query($conexion, $cadena_MANUAL);
$row_MANUAL = mysqli_fetch_array($consulta_MANUAL);

$cadena_TOTAL = "SELECT CONCAT('$',FORMAT(SUM(total),2)) FROM aportaciones ".$filtro_rp." AND anio = '$anio'";
$consulta_TOTAL = mysqli_query($conexion, $cadena_TOTAL);
$row_TOTAL = mysqli_fetch_array($consulta_TOTAL);

$imprimir = '
		<div class="col-md-3">
			<label>Total ESCARG:&nbsp;</label>'.$row_escarg[0].'
		</div>
		<div class="col-md-3">
			<label>Total NC:&nbsp;</label>'.$row_NC[0].'
		</div>
		<div class="col-md-3">
			<label>Total Manual:&nbsp;</label>'.$row_MANUAL[0].'
		</div>
		<div class="col-md-3">
			<label>Total General:&nbsp;</label>'.$row_TOTAL[0].'
		</div>
';

echo $imprimir;
?>