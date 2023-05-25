<?php
include '../global_seguridad/verificar_sesion.php';
$sucursal=$_POST['sucursal'];
$cadenaDescatalogados="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION, ID_SUCURSAL, FECHAHORA FROM ARTC_DESCATALOGADOS WHERE ACTIVO=1 AND ID_SUCURSAL='$sucursal'";
$consultaDescatalogados=mysqli_query($conexion,$cadenaDescatalogados);
$datos=array();
while($row=mysqli_fetch_array($consultaDescatalogados)){
  $cadenaSuc="SELECT nombre FROM sucursales WHERE id='$row[3]'";
  $consultaSuc=mysqli_query($conexion,$cadenaSuc);
  $rowSuc=mysqli_fetch_array($consultaSuc);
  array_push($datos,array(
    "id"=>$row[0],
    "artc_articulo"=>$row[1],
    "artc_descripcion"=>$row[2],
    "sucursal"=>$rowSuc[0],
    "fecha"=>$row[4],
    "usuario"=>''
  ));
}
ECHO utf8_encode(json_encode($datos));
?>