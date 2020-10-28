<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['codigo'];

$cadenaCodigo = "SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$codigo'";
$consultaPrincipal = oci_parse($conexion_central,$cadenaCodigo);
oci_execute($consultaPrincipal);
$row_articulo = oci_fetch_row($consultaPrincipal);

if($row_articulo[0]=="NULL"){
  echo "no existe";
}else{
  $array=array(
    $row_articulo[0]
  );
  $array_datos = json_encode($array);
  echo $array_datos;
}
?>