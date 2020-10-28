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
}

$folio = $_POST['folio'];

$cadena_consulta = "SELECT SUM(IMTN_MONTOIMPUESTO) IMPUESTOS, SUM(impn_subtotal) SUBTOTAL, ticn_aaaammddventa  FROM pvs_impticket WHERE CONCAT(ticn_aaaammddventa,ticn_folio) = '$folio' GROUP BY ticn_aaaammddventa";
$consulta_ticket = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_ticket);
$row = oci_fetch_row($consulta_ticket);
$conteo_ticket =count($row[0]);
//echo $conteo_ticket;
if($conteo_ticket==0){
  echo "no_existe";
}else{
  $cadena_configuracion = "SELECT id, tiraje_boletos, monto_boleto, fecha_inicio, fecha_fin FROM configuracion_sorteos WHERE activo = '1'";
  $consulta_conguracion = mysqli_query($conexion, $cadena_configuracion);
  $row_configuracion = mysqli_fetch_array($consulta_conguracion);
  $tiraje_boletos = $row_configuracion[1];
  $folio_inicial = str_replace("-","", $row_configuracion[3]);
  $folio_final = str_replace("-","",$row_configuracion[4]);
  $aaaammdd = $row[2];
  //echo $folio_inicial;
  if($aaaammdd<$folio_inicial || $aaaammdd>$folio_final){
    echo "fuera_rango";
  }
  else{
    $cadena_ajuste = "SELECT NVL(TICN_AJUSTE,0), TICN_VENTA  FROM PVS_TICKETS WHERE CONCAT(ticn_aaaammddventa,ticn_folio) = '$folio'";
    $consulta_ajuste = oci_parse($conexion_central, $cadena_ajuste);
    oci_execute($consulta_ajuste);
    $row_ajuste = oci_fetch_row($consulta_ajuste);

    $impuestos = $row[0];
    $subtotal = $row[1];
    $ajuste = $row_ajuste[0];
    $total_ticket = round($row_ajuste[1],2);

    $total = $impuestos+$total_ticket+$ajuste + 0.02;

    $boletos = $total/200;
    $boletos = floor($boletos);

    if($boletos<1){
      echo "no_boletos";

    }else{
      $array = array(
        $impuestos,
        $total_ticket,
        $ajuste,
        $total,
        $nombre_sede,
        $boletos
      );
      $array_datos = json_encode($array);
      echo $array_datos;
    }
  }
}
?>