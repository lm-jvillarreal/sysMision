<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

if(empty($sucursal)){
  $filtro_sucursal = "";
}else{
  $filtro_sucursal = "AND m.ALMN_ALMACEN = '$sucursal'";
}
$cadenaTotal = "SELECT 
                    NVL(COUNT(*),0)
                  FROM INV_MOVIMIENTOS m INNER JOIN COM_ENTRADAS e
                  ON m.movc_notaentrada = e.entn_entrada
                  AND m.almn_almacen = e.almn_almacen
                  WHERE m.MODC_TIPOMOV = 'ENTCOC'
                  AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                  AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1".$filtro_sucursal;
$consultaTotal = oci_parse($conexion_central, $cadenaTotal);
oci_execute($consultaTotal);
$rowTotal = oci_fetch_row($consultaTotal);

$cadenaParcial = "SELECT 
                    NVL(COUNT(*),0)
                  FROM INV_MOVIMIENTOS m INNER JOIN COM_ENTRADAS e
                  ON m.movc_notaentrada = e.entn_entrada
                  AND m.almn_almacen = e.almn_almacen
                  WHERE m.MODC_TIPOMOV = 'ENTCOC'
                  AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                  AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1
                  AND (SELECT ORDN_ESTATUS FROM com_ordenes_compra WHERE ordn_orden = e.ordn_orden)=4".$filtro_sucursal;
$consultaParcial = oci_parse($conexion_central, $cadenaParcial);
oci_execute($consultaParcial);
$rowParcial = oci_fetch_row($consultaParcial);

$cadenaCompleto = "SELECT 
                      NVL(COUNT(*),0)
                    FROM INV_MOVIMIENTOS m INNER JOIN COM_ENTRADAS e
                    ON m.movc_notaentrada = e.entn_entrada
                    AND m.almn_almacen = e.almn_almacen
                    WHERE m.MODC_TIPOMOV = 'ENTCOC'
                    AND m.MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
                    AND m.MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1
                    AND (SELECT ORDN_ESTATUS FROM com_ordenes_compra WHERE ordn_orden = e.ordn_orden)=5".$filtro_sucursal;
$consultaCompleto = oci_parse($conexion_central, $cadenaCompleto);
oci_execute($consultaCompleto);
$rowCompleto = oci_fetch_row($consultaCompleto);

$total = $rowTotal[0];
$parcial = $rowParcial[0];
$completo = $rowCompleto[0];

if($total == 0){
  $porcientoParcial = 0;
  $porcientoCompleto = 0;
}else{
  $porcientoParcial = ($parcial/$total)*100;
  $porcientoCompleto = ($completo/$total)*100;
}
$array = array(
  $parcial,
  round($porcientoParcial,2),
  $completo,
  round($porcientoCompleto,2)
);
$array = json_encode($array);
echo $array;
?>