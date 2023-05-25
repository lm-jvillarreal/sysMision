<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$artc_articulo=$_POST['artc_articulo'];
$cadenaDesc="SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$parametros_consulta = oci_parse($conexion_central, $cadenaDesc);
oci_execute($parametros_consulta);
$row = oci_fetch_row($parametros_consulta);
$conteo=count($row[0]);
if($conteo==0){
  echo "no_existe";
}else{
  $datos=json_encode(array(
    $row[0]
  ));
  echo $datos;
}
?>