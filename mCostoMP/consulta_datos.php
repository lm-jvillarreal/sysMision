<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Validar existencia en pv
$artc_articulo=$_POST['artc_articulo'];
$cadenaValidar = "SELECT COUNT(ARTC_DESCRIPCION) FROM PV_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$st=oci_parse($conexion_central,$cadenaValidar);
oci_execute($st);
$rowValidar=oci_fetch_array($st);
if($rowValidar[0]>0){
  $nombreTabla= "PV_ARTICULOS";
}else{
  $nombreTabla="COM_ARTICULOS";
}
$cadenaArtc="SELECT
              R.ALMN_ALMACEN,
              R.MODC_TIPOMOV,
              R.MODN_FOLIO,
              M.MOVC_CVEPROVEEDOR,
              (
              SELECT
                TRIM( PROC_NOMBRE ) 
              FROM
                CXP_PROVEEDORES 
              WHERE
              TRIM( PROC_CVEPROVEEDOR ) = TRIM( M.MOVC_CVEPROVEEDOR )) PROVEEDOR_NOMBRE,
              M.MOVD_FECHAAFECTACION,
              ( SELECT ARTC_DESCRIPCION FROM ".$nombreTabla." WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_DESCRIPCION,
              R.RMON_ULTIMOPRECIO,
              ( SELECT ARTC_UNIMEDIDA_VENTA FROM ".$nombreTabla." WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_UNIMEDIDA_VENTA
              FROM
              INV_RENGLONES_MOVIMIENTOS R
              INNER JOIN INV_MOVIMIENTOS M ON R.ALMN_ALMACEN = M.ALMN_ALMACEN 
              AND R.MODC_TIPOMOV = M.MODC_TIPOMOV 
              AND R.MODN_FOLIO = M.MODN_FOLIO 
              WHERE
              ( R.MODC_TIPOMOV = 'ENTCOC' OR R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ETRANS' ) 
              AND R.ARTC_ARTICULO = '$artc_articulo' 
              ORDER BY
              M.MOVD_FECHAAFECTACION DESC 
              FETCH FIRST 1 ROWS ONLY";
$st = oci_parse($conexion_central, $cadenaArtc);
oci_execute($st);
$rowDescripcion = oci_fetch_array($st);

if(count($rowDescripcion[0])==0){
  echo "no_existe";
}else{
  $datos_articulo= array(
    $rowDescripcion[0], //ALMN_ALMACEN
    $rowDescripcion[1], //MODC_TIPOMOV
    $rowDescripcion[2], //MODN_FOLIO
    $rowDescripcion[3], //MOVC_CVEPROVEEDOR
    $rowDescripcion[4], //PROC_NOMBRE
    $rowDescripcion[5], //MOVD_FECHAAFECTACION
    $rowDescripcion[6], //ARTC_DESCRIPCION
    $rowDescripcion[7], //RMON_ULTIMOPRECIO
    $rowDescripcion[8]  //UNIMEDIDA_VENTA
  );
  
  echo utf8_encode(json_encode($datos_articulo));
}
?>