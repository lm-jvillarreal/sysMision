<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fechahora=date("Y-m-d H:i:s");
$id_costeo=$_POST['id_costeo'];
$codigo_corte=$_POST['codigo_corte'];
$id_articulo=$_POST['id_articulo'];
$cantidad=$_POST['cantidad'];
$cadenaArticulos="SELECT ARTC_ARTICULO, ARTC_DESCRIPCION FROM carniceria_catalogorenglones WHERE ID='$id_articulo'";
$consultaArticulos=mysqli_query($conexion,$cadenaArticulos);
$rowArticulos=mysqli_fetch_array($consultaArticulos);

 //Obtener el precio de venta del platillo
 $cadenaPrecio="SELECT to_char(PRFN_PRECIO_CON_IMP, 'fm9990.00'), ARTC_UNIMEDIDA_VENTA FROM PV_PRECIOS_FINALES_VW WHERE ARTC_ARTICULO='$rowArticulos[0]' AND CFGC_SUCURSAL='$id_sede'";
 $consultaPrecio = oci_parse($conexion_central, $cadenaPrecio);
 oci_execute($consultaPrecio);
 $rowPrecio = oci_fetch_row($consultaPrecio);
 $conIva=$rowPrecio[0];

 $cadenaInsertar="INSERT INTO carniceria_costeorenglones(ID_COSTEO,CODIGO_CORTE, ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_CANTIDAD, ARTC_PRECIOVENTA, FECHAHORA, ACTIVO, USUARIO)VALUES('$id_costeo','$codigo_corte','$rowArticulos[0]','$rowArticulos[1]','$cantidad','$conIva','$fechahora','1','$id_usuario')";
 $insertar=mysqli_query($conexion,$cadenaInsertar);
 echo "ok";
?>