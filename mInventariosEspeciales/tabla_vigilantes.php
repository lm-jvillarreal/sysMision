<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaVigilantes="SELECT ID, CONCAT(NOMBRE,' ',AP_PATERNO,' ',AP_MATERNO), (SELECT nombre FROM sucursales WHERE id=vidvig_vigilantes.ID_SUCURSAL) FROM vidvig_vigilantes where activo = '1'";
$consultaVigilantes=mysqli_query($conexion,$cadenaVigilantes);
while($rowVigilantes=mysqli_fetch_array($consultaVigilantes)){
  $editar = "<center><a href='#' class='btn btn-success' onclick='editar($rowVigilantes[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'id'=>$rowVigilantes[0],
    'vigilante'=>$rowVigilantes[1],
    'sucursal'=>$rowVigilantes[2],
    'opciones'=>$editar
  ));
}
echo utf8_encode(json_encode($datos));
?>