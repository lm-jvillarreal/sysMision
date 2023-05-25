<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fechahora=date("Y-m-d H:i:s");

$id_corte=$_POST['id_corte'];
$corte=$_POST['corte'];
$artc_articulo=$_POST['artc_articulo'];

$cadenaDesc="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$st = oci_parse($conexion_central, $cadenaDesc);
      oci_execute($st);
$rowDescripcion = oci_fetch_array($st);
$descripcion=$rowDescripcion[0];

$cadenaInsert="INSERT INTO carniceria_catalogorenglones (ID_CATALOGO, CODIGO_CORTE, ARTC_ARTICULO, ARTC_DESCRIPCION, FECHAHORA, ACTIVO, USUARIO)VALUES('$id_corte','$corte','$artc_articulo','$descripcion','$fechahora','1','$id_usuario')";
$insertar=mysqli_query($conexion,$cadenaInsert);
echo "ok";
?>