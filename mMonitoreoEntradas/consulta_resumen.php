<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

if(empty($sucursal)){
  $filtro_sucursal = "";
}else{
  $filtro_sucursal = " AND m.ALMN_ALMACEN='$sucursal'";
}

$cadenaEntradas = "SELECT 
                      NVL((SELECT 
                          COUNT(*)
                      FROM INV_MOVIMIENTOS m
                      WHERE (m.MODC_TIPOMOV = 'ENTCOC' OR m.modc_tipomov='ENTSOC')
                      AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                      AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1
                      $filtro_sucursal),0) TOTAL,
                      NVL((SELECT 
                          COUNT(*)
                      FROM INV_MOVIMIENTOS m
                      WHERE (m.MODC_TIPOMOV = 'ENTCOC')
                      AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                      AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1
                      $filtro_sucursal),0) ENTCOC,
                      NVL((SELECT 
                          COUNT(*)
                      FROM INV_MOVIMIENTOS m
                      WHERE (m.modc_tipomov='ENTSOC')
                      AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                      AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1
                      $filtro_sucursal),0) ENTSOC
                    FROM DUAL";
$consultaResumen = oci_parse($conexion_central, $cadenaEntradas);
oci_execute($consultaResumen);
$rowEntradas = oci_fetch_row($consultaResumen);

$totalEntradas = $rowEntradas[0];
$totalENTCOC = $rowEntradas[1];
$totalENTSOC = $rowEntradas[2];

if($totalEntradas=="0"){
  $porcEntradas="0";
  $porcENTCOC = "0";
  $porcENTSOC = "0";
}else{
  $porcEntradas=100;
  $porcENTCOC = ($totalENTCOC/$totalEntradas)*100;
  $porcENTSOC = ($totalENTSOC/$totalEntradas)*100;

  $array = array(
    $totalEntradas,
    round($porcEntradas,2),
    $totalENTCOC,
    round($porcENTCOC,2),
    $totalENTSOC,
    round($porcENTSOC,2)
  );
  $array_datos = json_encode($array);
  echo $array_datos;
}
?>