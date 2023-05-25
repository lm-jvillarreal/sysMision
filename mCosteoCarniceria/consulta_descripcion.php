<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$origen=$_POST['origen'];
$artc_articulo= $_POST['artc_articulo'];

if($origen=='1'){
  $cadenaDescripcion="SELECT DESCRIPCION_CORTE FROM carniceria_catalogo WHERE CODIGO_CORTE='$artc_articulo'";
  $consultaDescripcion=mysqli_query($conexion,$cadenaDescripcion);
  $rowDescripcion=mysqli_fetch_array($consultaDescripcion);
  $descripcion=$rowDescripcion[0];
}elseif($origen=='2'){
  $cadenaDescripcion="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
  $st = oci_parse($conexion_central, $cadenaDescripcion);
  oci_execute($st);
  $rowDescripcion = oci_fetch_array($st);
  $descripcion=$rowDescripcion[0];
}

if(is_null($descripcion)){
  echo "no_existe";
}else{
  echo utf8_encode(json_encode(array($descripcion)));
}
?>