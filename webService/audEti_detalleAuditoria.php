<?php
include '../global_settings/conexion.php';

$folio=$_POST['folio'];
$id_usuario=$_POST['id_usuario'];

$cadenaConsulta="SELECT codigo, descripcion, cantidad FROM detalle_solicitud where id_solicitud='530'";
$consultaDetalle=mysqli_query($conexion,$cadenaConsulta);
$datos=array();
while($row=mysqli_fetch_array($consultaDetalle)){
  array_push($datos,array(
    'articulo'=>$row[0],
    'descripcion'=>$row[1],
    'cantidad'=>$row[2]
  ));
}
echo utf8_encode(json_encode($datos));
?>