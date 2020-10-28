<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$artc_articulo=$_POST['artc_articulo'];
$cadenaArticulo="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$consultaArticulo=oci_parse($conexion_central,$cadenaArticulo);
oci_execute($consultaArticulo);
$rowArticulo=oci_fetch_row($consultaArticulo);
$conteo=count($rowArticulo[0]);
if($conteo==0){
  echo "no_existe";
}else{
  echo $rowArticulo[0];
}
?>