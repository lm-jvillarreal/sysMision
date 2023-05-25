<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$artc_articulo=$_POST['artc_articulo'];
$almn_almacen=$_POST['sucursal'];
$cadena="SELECT
          R.MODC_TIPOMOV,
          R.MODN_FOLIO,
          M.MOVC_CVEPROVEEDOR,
          ( SELECT TRIM( PROC_NOMBRE ) FROM CXP_PROVEEDORES WHERE TRIM( PROC_CVEPROVEEDOR ) = TRIM( M.MOVC_CVEPROVEEDOR ) ) PROVEEDOR_NOMBRE,
          M.MOVD_FECHAAFECTACION,
          ( SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_DESCRIPCION,
          R.RMON_ULTIMOPRECIO,
          R.RMON_CANTSURTIDA,
          ( SELECT ARTC_UNIMEDIDA_VENTA FROM PV_ARTICULOS WHERE ARTC_ARTICULO = R.ARTC_ARTICULO ) ARTC_UNIMEDIDA_VENTA 
          FROM
          INV_RENGLONES_MOVIMIENTOS R
          INNER JOIN INV_MOVIMIENTOS M ON R.ALMN_ALMACEN = M.ALMN_ALMACEN 
          AND R.MODC_TIPOMOV = M.MODC_TIPOMOV 
          AND R.MODN_FOLIO = M.MODN_FOLIO 
          WHERE
          ( R.MODC_TIPOMOV = 'ENTCOC' OR R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ETRANS' ) 
          AND R.ARTC_ARTICULO = '$artc_articulo'
          AND R.ALMN_ALMACEN='$almn_almacen'
          ORDER BY
          M.MOVD_FECHAAFECTACION DESC FETCH FIRST 1 ROWS ONLY";
          
$consulta=oci_parse($conexion_central,$cadena);
oci_execute($consulta);
$row=oci_fetch_array($consulta);

$cadenaValidar="SELECT ID FROM carniceria_costeo WHERE ARTC_CODIGO='$artc_articulo' AND ENTRADA_FOLIO='$row[1]' AND ENTRADA_TIPO='$row[0]' AND PROC_CVEPROVEEDOR='$row[2]' AND ESTATUS='0'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
//echo $cadenaValidar;
if($rowValidar[0]==""){
  $id_costeo='';
}else{
  $id_costeo=$rowValidar[0];
}

echo utf8_encode(json_encode([
  $row[0], //MODC_TIPOMOV
  $row[1], //MODN_FOLIO
  $row[2], //MOVC_CVEPROVEEDOR
  $row[3], //PROVEEDOR_NOMBRE
  $row[5], //ARTC_DESCRIPCION
  $row[6], //RMON_ULTIMOPRECIO
  $row[7], //RMON_CANTSURTIDA
  $row[8],  //ARTC_UNIMEDIDA_VENTA
  $id_costeo
]));
?>