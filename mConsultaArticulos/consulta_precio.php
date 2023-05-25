<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';
$artc_articulo = $_POST['codigo'];
$datos=array();
for($i=1;$i<=6;$i++){
  switch($i){
    case 1:
      $conn=$conexion_do;
      $suc="DO";
      break;
    case 2:
      $conn=$conexion_arb;
      $suc="ARB";
      break;
    case 3:
      $conn=$conexion_vill;
      $suc="VILL";
      break;
    case 4:
      $conn=$conexion_all;
      $suc="ALL";
      break;
    case 5:
      $conn=$conexion_lp;
      $suc="LP";
    case 6:
      $conn=$conexion_mm;
      $suc="MM";
      break;
  }
  $cadena_consulta = "SELECT TO_CHAR(prfn_precio_con_imp,'$99,999.00') FROM pvs_precios_finales_vw where artc_articulo = '$artc_articulo'";
  $parametros_consulta = oci_parse($conn, $cadena_consulta);
  oci_execute($parametros_consulta);
  $row = oci_fetch_row($parametros_consulta);
  array_push($datos,array(TRIM($row[0])));
}
echo json_encode($datos);
?>