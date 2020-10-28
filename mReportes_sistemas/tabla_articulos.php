<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion_sucursales.php';
$datos=array();
$departamento=$_POST['departamento'];
$sucursal=$_POST['sucursal'];

$cadenaArticulos="SELECT
                    ARTC.ARTC_ARTICULO,
                    ARTC.ARTC_DESCRIPCION,
                    (
                    SELECT
                      TO_CHAR(MOVD_FECHAAFECTACION ,'DD/MM/YYYY')
                    FROM
                      INV_MOVTOS_KARDEX_VW 
                    WHERE
                      almn_almacen = '$sucursal' 
                      AND ARTC_ARTICULO = artc.artc_articulo 
                      AND MODN_FOLIO = (
                      SELECT
                        MAX( modn_folio ) 
                      FROM
                        INV_MOV_KARDEX_VW 
                      WHERE
                        almn_almacen = '$sucursal' 
                        AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                        AND ARTC_ARTICULO = artc.artc_articulo 
                        AND modn_folio < (
                        SELECT
                          MAX( modn_folio ) 
                        FROM
                          INV_MOV_KARDEX_VW 
                        WHERE
                          almn_almacen = '$sucursal' 
                          AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                          AND ARTC_ARTICULO = artc.artc_articulo 
                        )) 
                    AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' )) PENULTIMA_ENTRADA,
                    (
                    SELECT
                      TO_CHAR(MOVD_FECHAAFECTACION ,'DD/MM/YYYY')
                    FROM
                      INV_MOVTOS_KARDEX_VW 
                    WHERE
                      almn_almacen = '$sucursal' 
                      AND ARTC_ARTICULO = artc.artc_articulo 
                      AND MODN_FOLIO = (
                      SELECT
                        MAX( modn_folio ) 
                      FROM
                        INV_MOVTOS_KARDEX_VW 
                      WHERE
                        almn_almacen = '$sucursal' 
                        AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                        AND ARTC_ARTICULO = artc.artc_articulo 
                      ) 
                    AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' )) ULTIMA_ENTRADA,
                    (
                    SELECT
                      RMON_ULTIMOPRECIO 
                    FROM
                      INV_RENGLONES_MOVIMIENTOS 
                    WHERE
                      almn_almacen = '$sucursal' 
                      AND ARTC_ARTICULO = artc.artc_articulo 
                      AND MODN_FOLIO = (
                      SELECT
                        MAX( modn_folio ) 
                      FROM
                        INV_MOV_KARDEX_VW 
                      WHERE
                        almn_almacen = '$sucursal' 
                        AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                        AND ARTC_ARTICULO = artc.artc_articulo 
                        AND modn_folio < (
                        SELECT
                          MAX( modn_folio ) 
                        FROM
                          INV_MOV_KARDEX_VW 
                        WHERE
                          almn_almacen = '$sucursal' 
                          AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                          AND ARTC_ARTICULO = artc.artc_articulo 
                        )) 
                    AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' )) COSTO_ANTERIOR,
                    (
                    SELECT
                      RMON_ULTIMOPRECIO 
                    FROM
                      INV_RENGLONES_MOVIMIENTOS 
                    WHERE
                      almn_almacen = '$sucursal' 
                      AND ARTC_ARTICULO = artc.artc_articulo 
                      AND MODN_FOLIO = (
                      SELECT
                        MAX( modn_folio ) 
                      FROM
                        INV_MOV_KARDEX_VW 
                      WHERE
                        almn_almacen = '$sucursal' 
                        AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                        AND ARTC_ARTICULO = artc.artc_articulo 
                      ) 
                    AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' )) ULTIMO_COSTO,
                    (
                    SELECT
                      RMON_CANTSURTIDA 
                    FROM
                      INV_RENGLONES_MOVIMIENTOS 
                    WHERE
                      almn_almacen = '$sucursal' 
                      AND ARTC_ARTICULO = artc.artc_articulo 
                      AND MODN_FOLIO = (
                      SELECT
                        MAX( modn_folio ) 
                      FROM
                        INV_MOV_KARDEX_VW 
                      WHERE
                        almn_almacen = '$sucursal' 
                        AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' ) 
                        AND ARTC_ARTICULO = artc.artc_articulo 
                      ) 
                    AND ( MODC_TIPOMOV = 'ENTSOC' OR MODC_TIPOMOV = 'ENTCOC' OR MODC_TIPOMOV = 'ESCARG' )) CANTIDAD_SURTIDA,
                    ARTC.ARTC_UNIMEDIDA_VENTA,
                    (SELECT ARTN_PCT_IVA FROM INV_ARTICULOS_DETALLE WHERE ARTC_ARTICULO=artc.artc_articulo) IVA,
                    (SELECT ARTN_PCT_IEPS FROM INV_ARTICULOS_DETALLE WHERE ARTC_ARTICULO=artc.artc_articulo) IEPS,
                    ARTC.ARTC_IMPUESTO2
                    FROM
                    COM_ARTICULOS ARTC
                    INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = ARTC.ARTC_FAMILIA 
                    WHERE
                    FAM.FAMC_FAMILIAPADRE = '$departamento' 
                    AND ARTC.ARTD_BAJA IS NULL";
$st = oci_parse($conexion_central, $cadenaArticulos);
      oci_execute($st);

while($row_producto = oci_fetch_row($st)){

  $diferencia=$row_producto[5]-$row_producto[4];

  if($sucursal=='1'){
    $conexion_sucursal = $conexion_do;
  }elseif($sucursal=='2'){
    $conexion_sucursal = $conexion_arb;
  }elseif($sucursal=='3'){
    $conexion_sucursal = $conexion_vill;
  }elseif($sucursal=='4'){
    $conexion_sucursal = $conexion_all;
  }elseif($sucursal=='5'){
    $conexion_sucursal = $conexion_lp;
  }

  $cadenaOferta="SELECT prfn_precio_con_imp FROM pvs_precios_finales_vw WHERE artc_articulo = '$row_producto[0]'";
  $stoferta=oci_parse($conexion_sucursal,$cadenaOferta);
  oci_execute($stoferta);
  $rowOferta=oci_fetch_array($stoferta);

  array_push($datos,array(
    'artc_articulo'=>$row_producto[0],
    'artc_descripcion'=>$row_producto[1],
    'fecha_penultima'=>$row_producto[2],
    'fecha_ultima'=>$row_producto[3],
    'costo_penultimo'=>$row_producto[4],
    'costo_ultimo'=>$row_producto[5],
    'diferencia'=>$diferencia,
    'cantidad_ultima'=>$row_producto[6],
    'unidad_medida'=>$row_producto[7],
    'iva'=>$row_producto[8],
    'ieps'=>$row_producto[9],
    'ppublico'=>$rowOferta[0]
  ));
}
echo utf8_encode(json_encode($datos));
//echo $cadena_consulta;
?>