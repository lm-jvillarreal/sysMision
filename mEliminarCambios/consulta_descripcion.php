<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';
$folio = $_POST['folio'];
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
}elseif($sucursal=='6'){
	$conexion_central = $conexion_mm;
}

$cadenaDescripcion="SELECT iarc_descripcion FROM PVS_IMPORTACION_ARTICULOS WHERE iarn_id_importacion = '$folio'";
$consultaDescripcion = oci_parse($conexion_central, $cadenaDescripcion);
oci_execute($consultaDescripcion);
$row_descripcion=oci_fetch_row($consultaDescripcion);

$array=array(
  $row_descripcion[0]
);
$array=json_encode($array);
echo $array;
?>