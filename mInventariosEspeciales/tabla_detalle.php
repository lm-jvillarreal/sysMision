<?php
include '../global_seguridad/verificar_sesion.php';
$folio=$_POST['categoria'];
$datos=array();
$cadenaDetalle="SELECT ARTC_ARTICULO, ARTC_DESCRIPCION, CATEGORIA FROM vidvig_categorias WHERE FOLIO='$folio'";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  $ver = "<center><a href='#' class='btn btn-danger' onclick='eliminar($folio,$rowDetalle[0])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'codigo'=>$rowDetalle[0],
    'descripcion'=>$rowDetalle[1],
    'categoria'=>$rowDetalle[2],
    'opciones'=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>