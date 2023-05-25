<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion_sucursales.php';

if($id_sede=='1'){
  $conexion_sucursal = $conexion_do;
}elseif($id_sede=='2'){
  $conexion_sucursal = $conexion_arb;
}elseif($id_sede=='3'){
  $conexion_sucursal = $conexion_vill;
}elseif($id_sede=='4'){
  $conexion_sucursal = $conexion_all;
}elseif($id_sede=='5'){
  $conexion_sucursal = $conexion_lp;
}

$articulo=$_POST['codigo'];

$cadenaArticulo="SELECT
                  artc.ARTC_ARTICULO,
                  artc.ARTC_DESCRIPCION,
                  ( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, $id_sede, artc.ARTC_ARTICULO ) FROM dual ) AS Existencia,
                  (
                  SELECT
                    NVL( SUM( a.RMON_CANTSURTIDA ), 0 ) 
                  FROM
                    INV_RENGLONES_MOVIMIENTOS a 
                  WHERE
                    a.artc_articulo = artc.artc_articulo 
                    AND ( a.RMON_ESTATUS = '1' OR a.RMON_ESTATUS = '2' ) 
                    AND a.MODC_TIPOMOV = 'SALXVE' 
                    AND ALMN_ALMACEN = '$id_sede'
                  ) AS VENTAS_PENDIENTES,
                  (
                    SELECT
                      NVL( SUM( a.RMON_CANTSURTIDA ), 0 ) 
                    FROM
                      INV_RENGLONES_MOVIMIENTOS a 
                      INNER JOIN INV_MOVIMIENTOS m
                      ON a.MODC_TIPOMOV=m.MODC_TIPOMOV
                      and a.MODN_FOLIO=m.MODN_FOLIO
                      and a.ALMN_ALMACEN=m.ALMN_ALMACEN
                    WHERE
                      a.MODC_TIPOMOV='SIROTA'
                      and a.ALMN_ALMACEN='1'
                      AND a.ARTC_ARTICULO=artc.ARTC_ARTICULO
                      AND (a.RMON_ESTATUS='2' OR a.RMON_ESTATUS='3')
                      and m.MOVN_ESTATUS='2'
                  ) AS SIROTA
                FROM
                  PV_ARTICULOS artc 
                WHERE
                  artc.ARTC_ARTICULO = '$articulo'";
$consulta_principal = oci_parse($conexion_central, $cadenaArticulo);
oci_execute($consulta_principal);
$rowPrincipal=oci_fetch_row($consulta_principal);

$cadenaVentas="SELECT
                NVL(SUM( ARTN_CANTIDAD ),0) 
                FROM
                PVS_ARTICULOSTICKET artc
                INNER JOIN PVS_TICKETS tk ON artc.TICN_AAAAMMDDVENTA = tk.TICN_AAAAMMDDVENTA 
                AND artc.TICN_FOLIO = tk.TICN_FOLIO
                AND artc.TICC_SUCURSAL=tk.TICC_SUCURSAL
                WHERE artc.ARTC_ARTICULO='$articulo'
                AND (tk.TICN_ESTATUS=2)
                AND tk.TICC_SUCURSAL='$id_sede'";
$consulta_proceso=oci_parse($conexion_sucursal,$cadenaVentas);
oci_execute($consulta_proceso);
$rowProceso=oci_fetch_array($consulta_proceso);

$calculado=round($rowPrincipal[2]-$rowPrincipal[3]-$rowPrincipal[4]-$rowProceso[0],3);

echo json_encode(array(
  $rowPrincipal[0],
  $rowPrincipal[1],
  $rowPrincipal[2],
  $rowPrincipal[3],
  $rowPrincipal[4],
  $rowProceso[0],
  $calculado
));
?>