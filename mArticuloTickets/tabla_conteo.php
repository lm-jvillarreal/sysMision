<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];
$artc_articulo = $_POST['artc_articulo'];
$estatus = $_POST['estatus'];

if($estatus=='0'){
  $tabla="[]";
}else{

$folioIni = str_replace("-", "", $fecha_inicio);
$folioFin = str_replace("-", "", $fecha_fin);

$cuerpo ="";
$sucursal = 1;
while ($sucursal<=5) {
  $cadSuc = "SELECT nombre FROM sucursales where id ='$sucursal'";
  $consSuc = mysqli_query($conexion,$cadSuc);
  $rowSuc=mysqli_fetch_array($consSuc);

  $cadenaPasivos = "SELECT 
                    (SELECT COUNT(*) FROM PV_TICKETS WHERE ticn_aaaammddventa>=$folioIni AND ticn_aaaammddventa<=$folioFin AND TICN_ESTATUS ='3' AND TICC_SUCURSAL='$sucursal') TOTAL,
                    (SELECT COUNT(*) FROM PV_ARTICULOSTICKET WHERE ticn_aaaammddventa>=$folioIni AND ticn_aaaammddventa<=$folioFin AND ARTC_ARTICULO = '$artc_articulo' AND TICC_SUCURSAL='$sucursal') ARTÍCULO
                    FROM DUAL";
  $consultaPasivos = oci_parse($conexion_central, $cadenaPasivos);
  oci_execute($consultaPasivos);
  $row_conteos = oci_fetch_row($consultaPasivos);

  $porc = ($row_conteos[1]/$row_conteos[0])*100;
  $porc = round($porc,2);
  $tickets = "<a href='#' data-articulo = '$artc_articulo' data-inicio = '$folioIni' data-fin = '$folioFin' data-sucursal = '$sucursal' data-toggle = 'modal' data-target = '#modal-tickets'>$row_conteos[1]</a>";
  $renglon = "
  {
    \"conteo\": \"$sucursal\",
    \"sucursal\": \"$rowSuc[0]\",
    \"total\": \"$row_conteos[0]\",
    \"muestra\": \"$tickets\",
    \"porcentaje\": \"$porc\"
  },";
$cuerpo = $cuerpo.$renglon;
$sucursal = $sucursal +1;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
}
echo $tabla;