<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaSucursales="SELECT id,nombre,ifnull(inv_zonas,0) FROM sucursales WHERE activo=1 ORDER BY id ASC";
$consultaSucursales=mysqli_query($conexion,$cadenaSucursales);
while($rowSucursales=mysqli_fetch_array($consultaSucursales)){
  $editar = "<center><a href='#' class='btn btn-danger' onclick=\"editarZonas($rowSucursales[0],'$rowSucursales[1]')\"><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'id'=>$rowSucursales[0],
    'sucursal'=>$rowSucursales[1],
    'zonas'=>$rowSucursales[2],
    'opciones'=>$editar
  ));
}
echo utf8_encode(json_encode($datos));
?>