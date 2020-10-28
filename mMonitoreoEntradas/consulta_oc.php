<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

if(empty($sucursal)){
  $filtro_sucursal = "";
}else{
  switch($sucursal){
    case 1:
      $filtro_sucursal = " AND O.nombrealmacen = '1 SUC MATRIZ'";
    break;
    case 2:
      $filtro_sucursal = " AND O.nombrealmacen = '2 SUC ARBOLEDAS'";
    break;
    case 3:
      $filtro_sucursal = " AND O.nombrealmacen = '3 SUC VILLEGAS'";
    break;
    case 4:
      $filtro_sucursal = " AND O.nombrealmacen = '4 SUC ALLENDE'";
    break;
    case 5:
      $filtro_sucursal = " AND O.nombrealmacen = '05 SUC LA PETACA'";
    break;
    case 99:
      $filtro_sucursal = " AND O.nombrealmacen = '99 CEDIS LINARES'";
    break;
  }
}

$cadenaOC = "SELECT COUNT(DISTINCT(R.ORDN_ORDEN)) CONTEO
            FROM com_renglones_ordenes_compra R INNER JOIN com_ordenes_compra_vw O ON r.ordn_orden = o.ordn_orden
            WHERE R.rocd_estentrega >= TRUNC(TO_DATE('$fecha_inicial','YYYY-MM-DD'))
            AND R.rocd_estentrega <= TRUNC(TO_DATE('$fecha_final', 'YYYY-MM-DD'))+1".$filtro_sucursal;
$consultaOC = oci_parse($conexion_central, $cadenaOC);
oci_execute($consultaOC);
$rowOC = oci_fetch_row($consultaOC);

$array = array(
  $rowOC[0]
);
$array = json_encode($array);
echo $array;
?>