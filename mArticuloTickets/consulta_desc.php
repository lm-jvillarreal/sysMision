<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$artc_articulo=$_POST['artc_articulo'];

$cadenaDesc ="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$consultaDesc = oci_parse($conexion_central, $cadenaDesc);
oci_execute($consultaDesc);
$row_desc = oci_fetch_row($consultaDesc);
$conteo = count($row_desc[0]);
if($conteo==0){
  echo "no";
}else{
  $array=array(
    $row_desc[0]
  );
  $array=json_encode($array);
  echo $array;
}
?>