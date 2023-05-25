<?php
include '../global_seguridad/verificar_sesion.php';
$origen=$_POST['origen'];
$folio=$_POST['folio'];

if($origen=='1'){
  $cadena="SELECT ID, CODIGO_CORTE, DESCRIPCION_CORTE FROM carniceria_catalogo WHERE ID='$folio'";
  $consulta=mysqli_query($conexion,$cadena);
  $row=mysqli_fetch_array($consulta);
  $id=$row[0];
  $corte=$row[1];
  $descripcion=$row[2];
}elseif($origen=='2'){
  $cadenaCosteo="SELECT ID, ARTC_CODIGO, ARTC_CORTE FROM  carniceria_costeo WHERE ID='$folio'";
  $consultaCosteo=mysqli_query($conexion,$cadenaCosteo);
  $row=mysqli_fetch_array($consultaCosteo);
  $id=$row[0];
  $corte=$row[1];
  $descripcion=$row[2];
}
echo utf8_encode(json_encode(array($id,$corte,$descripcion)));
?>