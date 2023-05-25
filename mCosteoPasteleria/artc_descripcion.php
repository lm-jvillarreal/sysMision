<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$artc_articulo=$_POST['artc_articulo'];
$cadena="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$consulta=oci_parse($conexion_central, $cadena);
          oci_execute($consulta);
$row=oci_fetch_row($consulta);

if(is_null($row[0])){
  echo "no_existe";
}else{
  echo utf8_encode(json_encode(array($row[0])));
}
?>