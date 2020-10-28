<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$sucursal = $_POST['sucursal'];

if($sucursal=='1'){
  $opcion_1 = '2';
  $letra_1 = "ARBOLEDAS";
  $opcion_2 = '3';
  $letra_2 = "VILLEGAS";
  $opcion_3 = '4';
  $letra_3 = "ALLENDE";
}elseif($sucursal=='2'){
  $opcion_1 = '1';
  $letra_1 = "DIAZ ORDAZ";
  $opcion_2 = '3';
  $letra_2 = "VILLEGAS";
  $opcion_3 = '4';
  $letra_3 = "ALLENDE";
}elseif($sucursal=='3'){
  $opcion_1 = '1';
  $letra_1 = "DIAZ ORDAZ";
  $opcion_2 = '2';
  $letra_2 = "ARBOLEDAS";
  $opcion_3 = '4';
  $letra_3 = "ALLENDE";
}elseif($sucursal=='4'){
  $opcion_1 = '1';
  $letra_1 = "DIAZ ORDAZ";
  $opcion_2 = '2';
  $letra_2 = "ARBOLEDAS";
  $opcion_3 = '3';
  $letra_3 = "VILLEGAS";
}

$cadenaDetalle = "SELECT
                    (SELECT COUNT(*) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '$sucursal' AND tran_almacen_destino='$opcion_1' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '2019/01/01', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '2019/12/31', 'YYYY/MM/DD' ))+1),
                    (SELECT COUNT(*) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '$sucursal' AND tran_almacen_destino='$opcion_2' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '2019/01/01', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '2019/12/31', 'YYYY/MM/DD' ))+1),
                    (SELECT COUNT(*) FROM INV_TRANSFERENCIAS WHERE ALMN_ALMACEN = '$sucursal' AND tran_almacen_destino='$opcion_3' AND TRAD_FECHA_CAPTURA >= trunc(TO_DATE( '2019/01/01', 'YYYY/MM/DD' )) AND TRAD_FECHA_CAPTURA < trunc(TO_DATE( '2019/12/31', 'YYYY/MM/DD' ))+1)
                  FROM DUAL";
$consultaDetalle = oci_parse($conexion_central, $cadenaDetalle);
oci_execute($consultaDetalle);
$rowDetalle = oci_fetch_row($consultaDetalle);

$cuerpo="
  {
    \"name\": \"$letra_1\",
    \"y\": $rowDetalle[0],
    \"drilldown\": null
  },
  {
    \"name\": \"$letra_2\",
    \"y\": $rowDetalle[1],
    \"drilldown\": null
  },
  {
    \"name\": \"$letra_3\",
    \"y\": $rowDetalle[2],
    \"drilldown\": null
  }
";
echo $cuerpo;
?>