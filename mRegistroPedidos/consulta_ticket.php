<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$fecha_resta_actual = date('Y-m-d');
$hora = date('H:i:s');

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
	$conexion_central = $conexion_lp;
}elseif($id_sede=='6'){
	$conexion_central = $conexion_mm;
}

$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];
$folio = $_POST['folio'];

$cadena_consulta = "SELECT
                      ROUND( TICN_VENTA, 2 ) SUBTOTAL,
                      ( SELECT SUM( IMTN_MONTOIMPUESTO ) FROM PVS_IMPTICKET WHERE TICC_SUCURSAL = TK.TICC_SUCURSAL AND TICN_AAAAMMDDVENTA = TK.TICN_AAAAMMDDVENTA AND TICN_FOLIO = TK.TICN_FOLIO ) IMPUESTOS,
                      TICN_AJUSTE 
                    FROM
                      PVS_TICKETS TK 
                    WHERE
                      TICN_AAAAMMDDVENTA = '$prefijo' 
                      AND TICN_FOLIO = '$consecutivo'
                      AND TICC_SUCURSAL ='$id_sede'";
                      
$consulta_ticket = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_ticket);
$row = oci_fetch_row($consulta_ticket);
$conteo_ticket =count($row[0]);
if($conteo_ticket==0){
  echo "no_existe";
}else{
  $total=$row[0]+$row[1]+$row[2];
  $total=round($total,2);
  $boletos=$total/200;
  $boletos=floor($boletos);
  $array = array(
    $total,
    $boletos
  );
  $array_datos = json_encode($array);
  echo $array_datos;
}
?>