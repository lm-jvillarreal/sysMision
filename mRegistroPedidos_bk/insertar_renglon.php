<?php
 include '../global_seguridad/verificar_sesion.php';
 include '../global_settings/conexion_sucursales.php';
 
 $folio = $_POST['pedido'];
 $articulo = $_POST['articulo'];
 $cantidad = $_POST['cantidad'];

if($id_sede=='1'){
  $conexion_central = $conexion_do;
}elseif($id_sede=='2'){
  $conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
  $conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
  $conexion_central = $conexion_all;
}

$cadena_articulo = "SELECT  a_v.ARTC_ARTICULO, 
                            a_v.ARTC_DESCRIPCION,
                            a.ARTC_UNIMEDIDA_VENTA,
                            a.ARTN_PRECIOVENTA,
                            a_v.prfn_precio_con_imp,
                            a_v.prfn_precio_con_imp_y_desc,
                            a_v.open_clave_agrupacion
                    FROM pvs_precios_finales_vw a_v
                    INNER JOIN PVS_ARTICULOS a ON a_v.ARTC_ARTICULO = a.artc_articulo 
                    WHERE a_v.artc_articulo = '$articulo'";

$parametros_consulta = oci_parse($conexion_central, $cadena_articulo);
oci_execute($parametros_consulta);
$rowArticulo = oci_fetch_row($parametros_consulta);
if(is_null($rowArticulo[6])){
  $precio = $rowArticulo[4];
}else{
  $precio=$rowArticulo[5];
}
$precio_renglon = $precio*$cantidad;

$cadenaInsertar = "INSERT INTO pv_renglonespedido(ID_PEDIDO,ARTC_ARTICULO,ARTC_DESCRIPCION,ARTC_UNIDADMEDIDA,ARTC_PRECIOANTIMP,ARTC_PRECIOVENTA,CANTIDAD,ARTC_PRECIORENGLON)VALUES('$folio','$articulo','$rowArticulo[1]','$rowArticulo[2]','$precio','$precio','$cantidad','$precio_renglon')";
$insertarDetalle = mysqli_query($conexion,$cadenaInsertar);
echo $cadenaInsertar;
?>