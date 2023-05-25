<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion_sucursales.php';

$folio_hoy=date("Y").date("m").date("d");

$folio=$_POST['folio_modal'];
$cadenaDetalle="SELECT
                  FOLIO_FECHAINICIO,
                  FOLIO_FECHAFIN,
                  FOLIO_SUCURSAL,
                  ARTC_ARTICULO, 
                  ARTC_DESCRIPCION, 
                  ARTC_COSTO, 
                  ARTC_PRECIOVENTA, 
                  ARTC_PRECIOOFERTA, 
                  INVENTARIO_INICIAL, 
                  CANTIDAD_COMPRA, 
                  INV_ETRANS, 
                  INV_EXDEV, 
                  INV_ENTRADAS, 
                  INV_TOTALENTRADAS, 
                  INV_SALXVE, 
                  INV_STRANS, 
                  INV_SALIDAS, 
                  INV_SGRAL, 
                  INV_TOTALSALIDAS, 
                  FECHAHORA_FOLIO, 
                  ACTIVO, 
                  USUARIO 
                FROM com_kardexMovimientos WHERE FOLIO='$folio'";

$detalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($detalle)){
  $inicio=str_replace('-','',$rowDetalle[0]);
  $fin=str_replace('-','',$rowDetalle[1]);
  $date = date_create($rowDetalle[0]);
  $fecha_inicial=date_format($date,'d-m-Y');

  $cadenaDescripcion = "SELECT
  artc_articulo, artc_descripcion, prfn_precio_con_imp PPUBLICO,
  (SELECT spin_articulos.fn_existencia_a_fecha(13, NULL, NULL, 1, 1, $rowDetalle[2], '$rowDetalle[3]',trunc(TO_DATE ('$fecha_inicial', 'DD/MM/YYYY'))) FROM dual) Inicial,
  (SELECT spin_articulos.fn_precio_ultima_compra_mn(13, NULL, NULL, 1, 1, $rowDetalle[2], '$rowDetalle[3]') FROM dual) CostoUE,
  (SELECT NVL(SUM(artn_cantidad),0) FROM pv_ventas_reporte_vw WHERE TICC_SUCURSAL='$rowDetalle[2]' AND (TICN_AAAAMMDDVENTA>=$inicio AND ticn_aaaammddventa<=$fin) AND ARTC_ARTICULO='$rowDetalle[3]' AND (ticn_tipomov='1' OR ticn_tipomov='9')) VENTA,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='ENTCOC' OR MODC_TIPOMOV='ENTSOC')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) COMPRA,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='ETRANS')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) ETRANS,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='EXDEV')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) EXDEV,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='AJUPOS' OR
       MODC_TIPOMOV='RAPOS' OR
       MODC_TIPOMOV='ECHORI' OR
       MODC_TIPOMOV='EGRAL' OR
       MODC_TIPOMOV='ENTGRA' OR
       MODC_TIPOMOV='ENTMEC' OR
       MODC_TIPOMOV='ENTPRE' OR
       MODC_TIPOMOV='ESCARG' OR
       MODC_TIPOMOV='ETRASE' OR
       MODC_TIPOMOV='EXCOMP' OR
       MODC_TIPOMOV='EXCONV' OR
       MODC_TIPOMOV='EXVIGI')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) OTENT,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='STRANS')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) STRANS,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='SGRAL')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) SGRAL,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='DEVPRO' OR MODC_TIPOMOV='DEVCTR' OR MODC_TIPOMOV='DMPROV')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) DEV,
  (SELECT 
      NVL(SUM(rmon_cantsurtida),0) 
  FROM INV_MOVTOS_KARDEX_VW 
  WHERE almn_almacen='$rowDetalle[2]'
  AND artc_articulo='$rowDetalle[3]' 
  AND (MODC_TIPOMOV='AJUNEG' OR
  MODC_TIPOMOV='RANEG' OR
   MODC_TIPOMOV='ASTRAN' OR
   MODC_TIPOMOV='SALMEQ' OR
   MODC_TIPOMOV='SCHORI' OR
   MODC_TIPOMOV='SFCBOT' OR
   MODC_TIPOMOV='STRASE' OR
   MODC_TIPOMOV='ENTPRE' OR
   MODC_TIPOMOV='SVALPR' OR
   MODC_TIPOMOV='SXCONV' OR
   MODC_TIPOMOV='SXMBOD' OR
   MODC_TIPOMOV='SMXCAR' OR
   MODC_TIPOMOV='SXMEDO' OR
   MODC_TIPOMOV='SXMCAD' OR
   MODC_TIPOMOV='SXMFCI' OR
   MODC_TIPOMOV='SXMFTA' OR
   MODC_TIPOMOV='SXMPAN' OR
   MODC_TIPOMOV='SXMTOR' OR
   MODC_TIPOMOV='SXROB' OR
   MODC_TIPOMOV='TRADEP' OR
   MODC_TIPOMOV='VALCI' OR
   MODC_TIPOMOV='DEVCO' OR
   MODC_TIPOMOV='SGRAL')
  AND MOVD_FECHAAFECTACION >= trunc(TO_DATE ('$rowDetalle[0]', 'YYYY/MM/DD'))
  AND MOVD_FECHAAFECTACION < trunc(TO_DATE ('$rowDetalle[1]', 'YYYY/MM/DD'))+1) OTSAL,
  (SELECT 
      spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, $rowDetalle[2], '$rowDetalle[3]')
    FROM 
      dual
  ) Exist,
  (SELECT NVL(SUM(DETALLE.ARTN_CANTIDAD),0)
    FROM PV_ARTICULOSTICKET detalle 
    INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
    WHERE DETALLE.ARTC_ARTICULO = '$rowDetalle[3]'
    AND TIK.ticn_aaaammddventa BETWEEN '$folio_hoy' AND '$folio_hoy' 
    AND (TIK.TICN_ESTATUS = 2) 
    AND tik.TICC_SUCURSAL = '$rowDetalle[2]' 
    AND DETALLE.TICC_SUCURSAL = '$rowDetalle[2]') VENTAS_PROCESO,
    (SELECT
      NVL(SUM(RMON_CANTIDAD),0)
    FROM
      INV_RENGLONES_MOVIMIENTOS
    WHERE
      RMON_ESTATUS = 2
    AND MODC_TIPOMOV = 'SALXVE'
    AND ALMN_ALMACEN = '$rowDetalle[2]'
    AND ARTC_ARTICULO = '$rowDetalle[3]') PENDIENTES,
    (SELECT NVL(SUM(rm.rmon_cantidad),0) FROM INV_MOVIMIENTOS m
    INNER JOIN inv_renglones_movimientos rm ON rm.almn_almacen = m.almn_almacen 
    and m.modc_tipomov = rm.modc_tipomov 
    AND m.modn_folio = rm.modn_folio 
    WHERE  m.modc_tipomov = 'SIROTA'
    AND rm.artc_articulo = '$rowDetalle[3]'
    AND m.movn_estatus = '2'
    AND m.ALMN_ALMACEN = '$rowDetalle[2]'
    AND m.movd_fechaelaboracion >= TRUNC(TO_DATE('$rowDetalle[0]', 'YYYY/MM/DD')) 
    AND m.movd_fechaelaboracion <= TRUNC(TO_DATE('$rowDetalle[1]', 'YYYY/MM/DD')) +1) PENDIENTE_SIROTA
FROM pv_precios_finales_vw where artc_articulo = '$rowDetalle[3]' AND CFGC_SUCURSAL='$rowDetalle[2]'";
  $st = oci_parse($conexion_central, $cadenaDescripcion);
  oci_execute($st);
  $rowDescripcion = oci_fetch_array($st);

  if($rowDetalle[2]=='1'){
    $conexion_sucursal = $conexion_do;
  }elseif($rowDetalle[2]=='2'){
    $conexion_sucursal = $conexion_arb;
  }elseif($rowDetalle[2]=='3'){
    $conexion_sucursal = $conexion_vill;
  }elseif($rowDetalle[2]=='4'){
    $conexion_sucursal = $conexion_all;
  }elseif($rowDetalle[2]=='5'){
    $conexion_sucursal = $conexion_lp;
  }

  $cadenaOferta="SELECT prfn_precio_con_imp_y_desc FROM pvs_precios_finales_vw where artc_articulo = '$rowDetalle[3]'";
  $stoferta=oci_parse($conexion_sucursal,$cadenaOferta);
  oci_execute($stoferta);
  $rowOferta=oci_fetch_array($stoferta);

  $totent=$rowDescripcion[6]+$rowDescripcion[7]+$rowDescripcion[8]+$rowDescripcion[9];
  $totsal=$rowDescripcion[5]+$rowDescripcion[10]+$rowDescripcion[11]+$rowDescripcion[12]+$rowDescripcion[13];
  $teorico=$rowDescripcion[14]-$rowDescripcion[15]-$rowDescripcion[16]-$rowDescripcion[17];
  $cadenaActualiza = "UPDATE com_kardexMovimientos SET 
                        ARTC_DESCRIPCION='$rowDescripcion[1]',
                        ARTC_COSTO='$rowDescripcion[4]',
                        ARTC_PRECIOVENTA='$rowDescripcion[2]',
                        ARTC_PRECIOOFERTA='$rowOferta[0]',
                        INVENTARIO_INICIAL='$rowDescripcion[3]',
                        CANTIDAD_COMPRA='$rowDescripcion[6]',
                        INV_ETRANS='$rowDescripcion[7]',
                        INV_EXDEV='$rowDescripcion[8]',
                        INV_ENTRADAS='$rowDescripcion[9]',
                        INV_TOTALENTRADAS='$totent',
                        INV_SALXVE='$rowDescripcion[5]',
                        INV_STRANS='$rowDescripcion[10]',
                        INV_DEVOLUCIONES='$rowDescripcion[12]',
                        INV_SALIDAS='$rowDescripcion[13]',
                        INV_SGRAL='$rowDescripcion[11]',
                        INV_TOTALSALIDAS='$totsal',
                        INV_TEORICO='$teorico'
                      WHERE FOLIO='$folio' AND ARTC_ARTICULO='$rowDetalle[3]'

  ";
  $actualizaDescripcion = mysqli_query($conexion, $cadenaActualiza);
}
echo "ok";
?>