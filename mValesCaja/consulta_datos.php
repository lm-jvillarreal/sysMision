<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
  $conexion_central=$conexion_lp;
}elseif($id_sede=='6'){
  $conexion_central=$conexion_mm;
}

$cadena_consulta = "SELECT TICC_SUCURSAL, (SELECT USUC_NOMBRE FROM cfg_usuarios WHERE USUN_ID=t.ticc_cajero) CAJERO, TICN_VENTA, TICC_CAJERO FROM PVS_TICKETS T WHERE ticn_aaaammddventa='$prefijo' AND ticn_folio='$consecutivo' AND TICC_SUCURSAL='$id_sede'";
$consulta_ticket = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_ticket);
$row = oci_fetch_row($consulta_ticket);
$conteo_ticket =count($row[0]);

if($conteo_ticket==0){
  echo "no_existe";
}else{
  $array=array(
    $row[0],
    $row[2],
    $row[1],
    $row[3]
  );
  $array=json_encode($array);
  echo $array;
}
?>