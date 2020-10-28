<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$id_comprador = $_POST['id_comprador'];
$cadenaVigentes = "SELECT id, folio_oferta, articulo, descripcion, fecha_inicio, fecha_fin, cantidad FROM cargos_fondos WHERE id_comprador = '$id_comprador'";
$consultaVigentes = mysqli_query($conexion, $cadenaVigentes);

$cuerpo = "";
$conteo = 1;
while ($rowOferta=mysqli_fetch_array($consultaVigentes)) {
  $fecha_inicio = $rowOferta[4];
  $fecha_fin = $rowOferta[5];
  $periodo = $fecha_inicio.' - '.$fecha_fin;
  $fechaInicio = str_replace("-", "", $fecha_inicio);
  $fechaFin = str_replace("-", "", $fecha_fin);
  $cadenaVentas = "SELECT
  (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO = '$rowOferta[2]' AND ticn_aaaammddventa>='$fechaInicio' AND ticn_aaaammddventa<='$fechaFin' AND ticc_sucursal = '1') DO,
  (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO = '$rowOferta[2]' AND ticn_aaaammddventa>='$fechaInicio' AND ticn_aaaammddventa<='$fechaFin' AND ticc_sucursal = '2') ARB,
  (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO = '$rowOferta[2]' AND ticn_aaaammddventa>='$fechaInicio' AND ticn_aaaammddventa<='$fechaFin' AND ticc_sucursal = '3') VILL,
  (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO = '$rowOferta[2]' AND ticn_aaaammddventa>='$fechaInicio' AND ticn_aaaammddventa<='$fechaFin' AND ticc_sucursal = '4') AL,
  (SELECT NVL(SUM(ARTN_CANTIDAD),0) FROM PV_ARTICULOSTICKET WHERE ARTC_ARTICULO = '$rowOferta[2]' AND ticn_aaaammddventa>='$fechaInicio' AND ticn_aaaammddventa<='$fechaFin') TOTAL
  FROM DUAL";
  $consultaVentas = oci_parse($conexion_central, $cadenaVentas);
  oci_execute($consultaVentas);
  $rowVentas = oci_fetch_row($consultaVentas);
  $totalGeneral = $rowVentas[4]*$rowOferta[6];
  $totalGeneral = '$'.$totalGeneral;
  //echo $cadenaVentas;
  $renglon = "
  {
    \"folio\": \"$rowOferta[1]\",
    \"periodo\": \"$periodo\",
    \"codigo\": \"$rowOferta[2]\",
    \"descripcion\": \"$rowOferta[3]\",
    \"do\": \"$rowVentas[0]\",
    \"arb\": \"$rowVentas[1]\",
    \"vill\": \"$rowVentas[2]\",
    \"all\": \"$rowVentas[3]\",
    \"bonificacion\": \"$rowOferta[6]\",
    \"total\": \"$totalGeneral\"
  },";
  $cuerpo = $cuerpo.$renglon;
  $conteo = $conteo+1;
  }
  $cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
  $tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  echo $tabla;
?>