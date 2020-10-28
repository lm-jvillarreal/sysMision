<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

date_default_timezone_set("America/Monterrey");
$fecha_baja = date("Y-m-d");
$hora_baja = date("H:i:s");
$fecha = date("d/M/Y");

$folio=$_POST['folio'];
$sucursal=$_POST['sucursal'];

if($sucursal=='1' || empty($sucursal)){
	$conexion_central = $conexion_do;
}elseif($sucursal=='2'){
	$conexion_central = $conexion_arb;
}elseif($sucursal=='3'){
	$conexion_central = $conexion_vill;
}elseif($sucursal=='4'){
	$conexion_central = $conexion_all;
}elseif($sucursal=='5'){
	$conexion_central = $conexion_lp;
}

$cadenaUpdate = "DELETE FROM PVS_ARTICULOS_IMPORTACION WHERE IARN_ID_IMPORTACION = '$folio'";
$stid = oci_parse($conexion_central, $cadenaUpdate);
oci_execute($stid);
oci_free_statement($stid);
oci_close($conexion_central);
echo "ok";

?>