<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fechahora=date('Y-m-d H:i:s');

$cadenaCatalogo="SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, PROVEEDOR, RMON_ULTIMOPRECIO, UNIMEDIDA_COMPRA, UNIMEDIDA_VENTA, FACTOR_EMPAQUE, PORCENTAJE_MERMA, FECHAHORA, ACTIVO, USUARIO, ID FROM pasteleria_articulos";
$consultaCatalogo=mysqli_query($conexion,$cadenaCatalogo);
while($rowCatalogo=mysqli_fetch_array($consultaCatalogo)){
  $cadenaHistorial="INSERT INTO pasteleria_articulos_historial (ARTC_ARTICULO, ARTC_DESCRIPCION, PROVEEDOR, RMON_ULTIMOPRECIO, UNIMEDIDA_COMPRA, UNIMEDIDA_VENTA, FACTOR_EMPAQUE, PORCENTAJE_MERMA, FECHAHORA, ACTIVO, USUARIO)VALUES('$rowCatalogo[0]','$rowCatalogo[1]','$rowCatalogo[2]','$rowCatalogo[3]','$rowCatalogo[4]','$rowCatalogo[5]','$rowCatalogo[6]','$rowCatalogo[7]','$rowCatalogo[8]','$rowCatalogo[9]','$rowCatalogo[10]')";
  $insertarHistorial=mysqli_query($conexion,$cadenaHistorial);

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
              ( SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_DESCRIPCION,
              R.RMON_ULTIMOPRECIO,
              ( SELECT ARTC_UNIMEDIDA_VENTA FROM PV_ARTICULOS WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_UNIMEDIDA_VENTA
              FROM
              INV_RENGLONES_MOVIMIENTOS R
              INNER JOIN INV_MOVIMIENTOS M ON R.ALMN_ALMACEN = M.ALMN_ALMACEN 
              AND R.MODC_TIPOMOV = M.MODC_TIPOMOV 
              AND R.MODN_FOLIO = M.MODN_FOLIO 
              WHERE
              ( R.MODC_TIPOMOV = 'ENTCOC' OR R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ETRANS' ) 
              AND R.ARTC_ARTICULO = '$rowCatalogo[0]' 
              ORDER BY
              M.MOVD_FECHAAFECTACION DESC 
              FETCH FIRST 1 ROWS ONLY";
$st = oci_parse($conexion_central, $cadenaArtc);
oci_execute($st);
$rowDescripcion = oci_fetch_array($st);

$cadenaActualizar="UPDATE pasteleria_articulos SET ARTC_DESCRIPCION='$rowDescripcion[6]', PROVEEDOR='$rowDescripcion[3] $rowDescripcion[4]', RMON_ULTIMOPRECIO='$rowDescripcion[7]', UNIMEDIDA_COMPRA='$rowDescripcion[8]', UNIMEDIDA_VENTA='$rowCatalogo[5]', FACTOR_EMPAQUE='$rowCatalogo[6]', PORCENTAJE_MERMA='$rowCatalogo[7]', FECHAHORA='$fechahora', ACTIVO='1', USUARIO='$id_usuario' WHERE ID='$rowCatalogo[11]'";
$actualizar=mysqli_query($conexion,$cadenaActualizar);
}
echo "ok";
?>