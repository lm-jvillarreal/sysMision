<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaConsulta="SELECT id, nombre, descripcion, activo FROM categorias_modulos";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
  $activo = ($row[3]=="0") ? "" : "checked";
  $link_editar = "<center><a href='#' onclick='datos_editar($row[0])'>$row[0]</a></center>";
  $chk_activo = "<center><input type='checkbox' name='activo' id='activo' $activo onchange='activo($row[0])'></center>";
  array_push($datos,array(
    'id_categoria'=>$link_editar,
    'nombre_categoria'=>$row[1],
    'desc_categoria'=>$row[2],
    'activo_categoria'=>$chk_activo
  ));
}
echo utf8_encode(json_encode($datos));
?>